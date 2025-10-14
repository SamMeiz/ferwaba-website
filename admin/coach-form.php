<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

$team_id = null; $name = ''; $role = 'Head Coach'; $nationality = ''; $photo = '';
$error = '';

$teams = $mysqli->query("SELECT id,name FROM teams ORDER BY name ASC");

if ($editing) {
  $stmt = $mysqli->prepare("SELECT team_id,name,role,nationality,photo FROM coaches WHERE id=? LIMIT 1");
  $stmt->bind_param('i',$id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($row = $res->fetch_assoc()) {
    $team_id = $row['team_id'];
    $name = $row['name'];
    $role = $row['role'];
    $nationality = $row['nationality'];
    $photo = $row['photo'];
  } else { die('Coach not found'); }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $team_id = isset($_POST['team_id']) && ctype_digit($_POST['team_id']) ? (int)$_POST['team_id'] : null;
  $name = trim($_POST['name'] ?? '');
  $role = in_array(($_POST['role'] ?? ''), ['Head Coach','Assistant Coach','Team Staff']) ? $_POST['role'] : 'Head Coach';
  $nationality = trim($_POST['nationality'] ?? '');

  if (!$name) { $error = 'Name is required.'; }

  $uploadFileName = $photo;
  if (!$error && isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
      $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
      $safeName = 'coach_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . strtolower($ext);
      $destDir = __DIR__ . '/uploads/';
      if (!is_dir($destDir)) { mkdir($destDir, 0755, true); }
      if (move_uploaded_file($_FILES['photo']['tmp_name'], $destDir . $safeName)) {
        $uploadFileName = $safeName;
      } else { $error = 'Failed to upload photo.'; }
    } else { $error = 'Upload error.'; }
  }

  if (!$error) {
    if ($editing) {
      $stmt = $mysqli->prepare("UPDATE coaches SET team_id=?, name=?, role=?, nationality=?, photo=? WHERE id=? LIMIT 1");
      $stmt->bind_param('issssi', $team_id, $name, $role, $nationality, $uploadFileName, $id);
      if ($stmt->execute()) { redirect('coaches.php'); } else { $error = 'Failed to save coach.'; }
    } else {
      $stmt = $mysqli->prepare("INSERT INTO coaches(team_id,name,role,nationality,photo) VALUES(?,?,?,?,?)");
      $stmt->bind_param('issss', $team_id, $name, $role, $nationality, $uploadFileName);
      if ($stmt->execute()) { redirect('coaches.php'); } else { $error = 'Failed to create coach.'; }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $editing? 'Edit':'Add'; ?> Coach - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
<body>
<div class="container" style="max-width:720px;margin:24px auto">
  <div class="card"><div class="card-body">
    <h2 style="margin:0 0 12px"><?php echo $editing? 'Edit':'Add'; ?> Coach</h2>
    <?php if($error): ?><div style="color:#b91c1c;margin-bottom:8px"><?php echo sanitize($error); ?></div><?php endif; ?>
    <form method="post" enctype="multipart/form-data">
      <div class="grid col-2" style="margin-bottom:8px">
        <div>
          <label>Team</label>
          <select name="team_id" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
            <option value="">Unassigned</option>
            <?php while($t = $teams->fetch_assoc()): ?>
            <option value="<?php echo (int)$t['id']; ?>" <?php echo ($team_id==(int)$t['id'])?'selected':''; ?>><?php echo sanitize($t['name']); ?></option>
            <?php endwhile; ?>
          </select>
        </div>
        <div>
          <label>Role</label>
          <select name="role" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
            <option <?php echo $role==='Head Coach'?'selected':''; ?>>Head Coach</option>
            <option <?php echo $role==='Assistant Coach'?'selected':''; ?>>Assistant Coach</option>
            <option <?php echo $role==='Team Staff'?'selected':''; ?>>Team Staff</option>
          </select>
        </div>
      </div>
      <div class="grid col-2" style="margin-bottom:8px">
        <div>
          <label>Full Name</label>
          <input type="text" name="name" value="<?php echo sanitize($name); ?>" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
        </div>
        <div>
          <label>Nationality</label>
          <input type="text" name="nationality" value="<?php echo sanitize($nationality); ?>" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
        </div>
      </div>
      <div style="margin-bottom:12px">
        <label>Photo</label>
        <input type="file" name="photo" accept="image/*">
        <?php if($photo): ?><div class="muted">Current: <?php echo sanitize($photo); ?></div><?php endif; ?>
      </div>
      <div>
        <button class="btn" type="submit">Save</button>
        <a class="btn" style="margin-left:8px" href="coaches.php">Cancel</a>
      </div>
    </form>
  </div></div>
</div>
</body>
</html>


