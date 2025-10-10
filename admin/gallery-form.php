<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$team_id = null; $caption=''; $error='';
$teams = $mysqli->query("SELECT id,name FROM teams ORDER BY name ASC");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $team_id = isset($_POST['team_id']) && ctype_digit($_POST['team_id']) ? (int)$_POST['team_id'] : null;
  $caption = trim($_POST['caption'] ?? '');
  if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
    $error = 'Please select an image to upload.';
  }
  $fileName = '';
  if (!$error && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
    $safeName = 'gallery_' . time() . '_' . bin2hex(random_bytes(4)) . '.' . strtolower($ext);
    $destDir = __DIR__ . '/uploads/';
    if (!is_dir($destDir)) { mkdir($destDir, 0755, true); }
    if (move_uploaded_file($_FILES['image']['tmp_name'], $destDir . $safeName)) {
      $fileName = $safeName;
    } else { $error = 'Failed to upload image.'; }
  } elseif(!$error) {
    $error = 'Upload error.';
  }

  if (!$error) {
    $stmt = $mysqli->prepare("INSERT INTO gallery(team_id,image,caption) VALUES(?,?,?)");
    $stmt->bind_param('iss', $team_id, $fileName, $caption);
    if ($stmt->execute()) { redirect('/admin/gallery.php'); } else { $error = 'Failed to save gallery item.'; }
  }
}
?>
<!DOCTYPE html>
<html lang=\"en\">
<head>
  <meta charset=\"UTF-8\">
  <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
  <title>Upload Photo - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
<body>
<div class=\"container\" style=\"max-width:640px;margin:24px auto\">
  <div class=\"card\"><div class=\"card-body\">
    <h2 style=\"margin:0 0 12px\">Upload Photo</h2>
    <?php if($error): ?><div style=\"color:#b91c1c;margin-bottom:8px\"><?php echo sanitize($error); ?></div><?php endif; ?>
    <form method=\"post\" enctype=\"multipart/form-data\">
      <div style=\"margin-bottom:8px\">
        <label>Team</label>
        <select name=\"team_id\" style=\"width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px\">
          <option value=\"\">Unassigned</option>
          <?php while($t=$teams->fetch_assoc()): ?>
          <option value=\"<?php echo (int)$t['id']; ?>\" <?php echo ($team_id==(int)$t['id'])?'selected':''; ?>><?php echo sanitize($t['name']); ?></option>
          <?php endwhile; ?>
        </select>
      </div>
      <div style=\"margin-bottom:8px\">
        <label>Caption</label>
        <input type=\"text\" name=\"caption\" value=\"<?php echo sanitize($caption); ?>\" style=\"width:100%;padding:8px;border:1px solid #e5e7eb;border-radius:8px\">
      </div>
      <div style=\"margin-bottom:12px\">
        <label>Image</label>
        <input type=\"file\" name=\"image\" accept=\"image/*\" required>
      </div>
      <div>
        <button class=\"btn\" type=\"submit\">Upload</button>
        <a class=\"btn\" href=\"/admin/gallery.php\" style=\"margin-left:8px\">Cancel</a>
      </div>
    </form>
  </div></div>
</div>
</body>
</html>
