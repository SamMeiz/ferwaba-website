<?php 
require_once __DIR__ . '/../includes/config.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

$name = $gender = $division = $location = $logo = $description = '';
$error = '';

if ($editing) {
    $stmt = $mysqli->prepare("SELECT name,gender,division,location,logo,description FROM teams WHERE id=? LIMIT 1");
    $stmt->bind_param('i',$id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $name = $row['name'];
        $gender = $row['gender'];
        $division = $row['division'];
        $location = $row['location'];
        $logo = $row['logo'];
        $description = $row['description'];
    } else {
        die('Team not found');
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $gender = ($_POST['gender'] ?? '') === 'Women' ? 'Women' : 'Men';
    $division = ($_POST['division'] ?? '') === 'Division 2' ? 'Division 2' : 'Division 1';
    $location = trim($_POST['location'] ?? '');
    $description = trim($_POST['description'] ?? '');

    if (!$name) { $error = 'Name is required.'; }

    // Handle logo upload
    $uploadFileName = $logo; // keep existing if not uploading new
    if (!$error && isset($_FILES['logo']) && $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE) {
        if ($_FILES['logo']['error'] === UPLOAD_ERR_OK) {
            $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
            $safeName = 'team_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . strtolower($ext);
            $destDir = __DIR__ . '/uploads/';
            if (!is_dir($destDir)) { mkdir($destDir, 0755, true); }
            if (move_uploaded_file($_FILES['logo']['tmp_name'], $destDir . $safeName)) {
                $uploadFileName = $safeName;
            } else {
                $error = 'Failed to upload logo.';
            }
        } else {
            $error = 'Upload error.';
        }
    }

    if (!$error) {
        if ($editing) {
            // Update existing team
            $stmt = $mysqli->prepare("UPDATE teams SET name=?, gender=?, division=?, location=?, logo=?, description=? WHERE id=? LIMIT 1");
            $stmt->bind_param('ssssssi', $name, $gender, $division, $location, $uploadFileName, $description, $id);
            if ($stmt->execute()) { 
                redirect('teams.php'); 
            } else { 
                $error = 'Failed to save team.'; 
            }
        } else {
            // Insert new team
            $stmt = $mysqli->prepare("INSERT INTO teams(name,gender,division,location,logo,description) VALUES(?,?,?,?,?,?)");
            $stmt->bind_param('ssssss', $name, $gender, $division, $location, $uploadFileName, $description);
            if ($stmt->execute()) { 
                // Get the new team ID
                $new_team_id = $stmt->insert_id;

                // Auto-insert into standings with default values
                $mysqli->query("
                    INSERT INTO standings(
                        team_id, division, gender, games_played, wins, losses, points, win_percentage, games_behind
                    ) VALUES (
                        {$new_team_id},
                        '{$mysqli->real_escape_string($division)}',
                        '{$mysqli->real_escape_string($gender)}',
                        0, 0, 0, 0, 0, 0
                    )
                ");

                redirect('teams.php'); 
            } else { 
                $error = 'Failed to create team.'; 
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?php echo $editing? 'Edit':'Add'; ?> Team - FERWABA</title>
<link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
<body>
<div class="container" style="max-width:720px;margin:24px auto">
  <div class="card">
    <div class="card-body">
      <h2 style="margin:0 0 12px"><?php echo $editing? 'Edit':'Add'; ?> Team</h2>
      <?php if($error): ?><div style="color:#b91c1c;margin-bottom:8px"><?php echo sanitize($error); ?></div><?php endif; ?>
      <form method="post" enctype="multipart/form-data">
        <div style="margin-bottom:8px">
          <label>Team Name</label>
          <input type="text" name="name" value="<?php echo sanitize($name); ?>" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
        </div>
        <div class="grid col-2" style="margin-bottom:8px">
          <div>
            <label>Gender</label>
            <select name="gender" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
              <option value="Men" <?php echo $gender==='Men'?'selected':''; ?>>Men</option>
              <option value="Women" <?php echo $gender==='Women'?'selected':''; ?>>Women</option>
            </select>
          </div>
          <div>
            <label>Division</label>
            <select name="division" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
              <option value="Division 1" <?php echo $division==='Division 1'?'selected':''; ?>>Division 1</option>
              <option value="Division 2" <?php echo $division==='Division 2'?'selected':''; ?>>Division 2</option>
            </select>
          </div>
        </div>
        <div style="margin-bottom:8px">
          <label>Location</label>
          <input type="text" name="location" value="<?php echo sanitize($location); ?>" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
        </div>
        <div style="margin-bottom:8px">
          <label>Logo</label>
          <input type="file" name="logo" accept="image/*">
          <?php if($logo): ?><div class="muted">Current: <?php echo sanitize($logo); ?></div><?php endif; ?>
        </div>
        <div style="margin-bottom:12px">
          <label>Description</label>
          <textarea name="description" rows="4" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px"><?php echo sanitize($description); ?></textarea>
        </div>
        <div>
          <button class="btn" type="submit">Save</button>
          <a class="btn" href="teams.php" style="margin-left:8px">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>
