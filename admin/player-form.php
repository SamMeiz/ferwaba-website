<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int)$_GET['id'] : 0;
$editing = $id > 0;

$team_id = null;
$name = $position = $height = $nationality = '';
$jersey_number = '';
$photo = '';
$error = '';

// Teams for select
$teams = $mysqli->query("SELECT id,name FROM teams ORDER BY name ASC");

if ($editing) {
  $stmt = $mysqli->prepare("SELECT team_id,name,position,height,nationality,jersey_number,photo FROM players WHERE id=? LIMIT 1");
  $stmt->bind_param('i',$id);
  $stmt->execute();
  $res = $stmt->get_result();
  if ($row = $res->fetch_assoc()) {
    $team_id = $row['team_id'];
    $name = $row['name'];
    $position = $row['position'];
    $height = $row['height'];
    $nationality = $row['nationality'];
    $jersey_number = $row['jersey_number'];
    $photo = $row['photo'];
  } else { die('Player not found'); }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $team_id = isset($_POST['team_id']) && ctype_digit($_POST['team_id']) ? (int)$_POST['team_id'] : null;
  $name = trim($_POST['name'] ?? '');
  $position = trim($_POST['position'] ?? '');
  $height = trim($_POST['height'] ?? '');
  $nationality = trim($_POST['nationality'] ?? '');
  $jersey_number = (int)($_POST['jersey_number'] ?? 0);

  if (!$name) { $error = 'Name is required.'; }

  // photo upload
  $uploadFileName = $photo;
  if (!$error && isset($_FILES['photo']) && $_FILES['photo']['error'] !== UPLOAD_ERR_NO_FILE) {
    if ($_FILES['photo']['error'] === UPLOAD_ERR_OK) {
      $ext = pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION);
      $safeName = 'player_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . strtolower($ext);
      $destDir = __DIR__ . '/uploads/';
      if (!is_dir($destDir)) { mkdir($destDir, 0755, true); }
      if (move_uploaded_file($_FILES['photo']['tmp_name'], $destDir . $safeName)) {
        $uploadFileName = $safeName;
      } else { $error = 'Failed to upload photo.'; }
    } else { $error = 'Upload error.'; }
  }

  if (!$error) {
    if ($editing) {
      $stmt = $mysqli->prepare("UPDATE players SET team_id=?, name=?, position=?, height=?, nationality=?, jersey_number=?, photo=? WHERE id=? LIMIT 1");
      $stmt->bind_param('issssisi', $team_id, $name, $position, $height, $nationality, $jersey_number, $uploadFileName, $id);
      if ($stmt->execute()) { redirect('players.php'); } else { $error = 'Failed to save player.'; }
    } else {
      $stmt = $mysqli->prepare("INSERT INTO players(team_id,name,position,height,nationality,jersey_number,photo) VALUES(?,?,?,?,?,?,?)");
      $stmt->bind_param('issssis', $team_id, $name, $position, $height, $nationality, $jersey_number, $uploadFileName);
      if ($stmt->execute()) { redirect('players.php'); } else { $error = 'Failed to create player.'; }
    }
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo $editing? 'Edit':'Add'; ?> Player - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
<body>
<div class="container" style="max-width:720px;margin:24px auto">
  <div class="card"><div class="card-body">
    <h2 style="margin:0 0 12px"><?php echo $editing? 'Edit':'Add'; ?> Player</h2>
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
          <label>Jersey #</label>
          <input type="number" name="jersey_number" value="<?php echo (int)$jersey_number; ?>" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
        </div>
      </div>
      <div class="grid col-2" style="margin-bottom:8px">
        <div>
          <label>Full Name</label>
          <input type="text" name="name" value="<?php echo sanitize($name); ?>" required style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
        </div>
        <div>
          <label>Position</label>
          <input type="text" name="position" value="<?php echo sanitize($position); ?>" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
        </div>
      </div>
      <div class="grid col-2" style="margin-bottom:8px">
        <div>
          <label>Height</label>
          <input type="text" name="height" value="<?php echo sanitize($height); ?>" placeholder="e.g., 6'5\" or 195cm" style="width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px">
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
        <a class="btn" style="margin-left:8px" href="players.php">Cancel</a>
      </div>
    </form>
  </div></div>
</div>
</body>
</html>


