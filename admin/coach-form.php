<?php require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int) $_GET['id'] : 0;
$editing = $id > 0;

$team_id = null;
$name = '';
$role = 'Head Coach';
$nationality = '';
$photo = '';
$error = '';
$csrf_token = generate_csrf_token();

try {
  $teams = $db->query("SELECT id, name FROM teams ORDER BY name ASC")->fetchAll();

  if ($editing) {
    $stmt = $db->prepare("SELECT team_id, name, role, nationality, photo FROM coaches WHERE id=? LIMIT 1");
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    if ($row) {
      $team_id = $row['team_id'];
      $name = $row['name'];
      $role = $row['role'];
      $nationality = $row['nationality'];
      $photo = $row['photo'];
    } else {
      die('Coach not found');
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf_token();
    $team_id = isset($_POST['team_id']) && ctype_digit($_POST['team_id']) ? (int) $_POST['team_id'] : null;
    $name = trim($_POST['name'] ?? '');
    $role = in_array(($_POST['role'] ?? ''), ['Head Coach', 'Assistant Coach', 'Team Staff']) ? $_POST['role'] : 'Head Coach';
    $nationality = trim($_POST['nationality'] ?? '');

    if (!$name) {
      $error = 'Name is required.';
    }

    $uploadFileName = $photo;
    if (!$error && isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
      $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
      $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
      $uploadError = validate_upload($_FILES['photo'], $allowedExts, 5242880, $allowedMimes);
      if ($uploadError) {
        $error = $uploadError;
      } else {
        $ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $safeName = generate_safe_filename('coach', $ext);
        $destDir = __DIR__ . '/uploads/';
        if (!is_dir($destDir)) {
          mkdir($destDir, 0755, true);
        }
        if (move_uploaded_file($_FILES['photo']['tmp_name'], $destDir . $safeName)) {
          $uploadFileName = $safeName;
        } else {
          $error = 'Failed to upload photo.';
        }
      }
    }

    if (!$error) {
      if ($editing) {
        $stmt = $db->prepare("UPDATE coaches SET team_id=?, name=?, role=?, nationality=?, photo=? WHERE id=? LIMIT 1");
        $stmt->execute([$team_id, $name, $role, $nationality, $uploadFileName, $id]);
        audit_log($db, 'Edit Coach', "Updated coach: $name (ID: $id)");
      } else {
        $stmt = $db->prepare("INSERT INTO coaches(team_id, name, role, nationality, photo) VALUES(?, ?, ?, ?, ?)");
        $stmt->execute([$team_id, $name, $role, $nationality, $uploadFileName]);
        $newId = $db->lastInsertId();
        audit_log($db, 'Add Coach', "Created coach: $name (ID: $newId)");
      }
      redirect('coaches.php');
    }
  }
} catch (PDOException $e) {
  error_log("Coach Form Error: " . $e->getMessage());
  $error = 'A database error occurred.';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $editing ? 'Edit' : 'Add'; ?> Coach - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/admin.css'); ?>">
</head>

<body>
  <div class="container" style="max-width:720px;margin:24px auto">
    <div class="card">
      <div class="card-body">
        <h2 style="margin:0 0 12px"><?php echo $editing ? 'Edit' : 'Add'; ?> Coach</h2>
        <?php if ($error): ?>
          <div style="color:#b91c1c;margin-bottom:8px"><?php echo sanitize($error); ?></div><?php endif; ?>
        <form method="post" enctype="multipart/form-data">
          <input type="hidden" name="csrf_token" value="<?php echo sanitize($csrf_token); ?>">
          <div class="grid col-2" style="margin-bottom:8px">
            <div>
              <label>Team</label>
              <select name="team_id" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                <option value="">Unassigned</option>
                <?php foreach ($teams as $t): ?>
                  <option value="<?php echo (int) $t['id']; ?>" <?php echo ($team_id == (int) $t['id']) ? 'selected' : ''; ?>>
                    <?php echo sanitize($t['name']); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div>
              <label>Role</label>
              <select name="role" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
                <option <?php echo $role === 'Head Coach' ? 'selected' : ''; ?>>Head Coach</option>
                <option <?php echo $role === 'Assistant Coach' ? 'selected' : ''; ?>>Assistant Coach</option>
                <option <?php echo $role === 'Team Staff' ? 'selected' : ''; ?>>Team Staff</option>
              </select>
            </div>
          </div>
          <div class="grid col-2" style="margin-bottom:8px">
            <div>
              <label>Full Name</label>
              <input type="text" name="name" value="<?php echo sanitize($name); ?>" required
                style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
            </div>
            <div>
              <label>Nationality</label>
              <input type="text" name="nationality" value="<?php echo sanitize($nationality); ?>"
                style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
            </div>
          </div>
          <div style="margin-bottom:12px">
            <label>Photo</label>
            <input type="file" name="photo" accept="image/*">
            <?php if ($photo): ?>
              <div class="muted">Current: <?php echo sanitize($photo); ?></div><?php endif; ?>
          </div>
          <div>
            <button class="btn" type="submit">Save</button>
            <a class="btn" style="margin-left:8px" href="coaches.php">Cancel</a>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>

</html>
