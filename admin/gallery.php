<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$imgs = $mysqli->query("SELECT g.id,g.image,g.caption,t.name AS team_name FROM gallery g LEFT JOIN teams t ON t.id=g.team_id ORDER BY g.uploaded_at DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Gallery - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('css/style.css'); ?>">
</head>
<body>
<div class="container" style="margin:20px auto">
  <div class="section-title">
    <h2>Gallery</h2>
    <a class="btn" href="<?php echo asset_url('/gallery-form.php'); ?>">Upload Photo</a>
  </div>
  <div class="grid col-3">
    <?php while($g=$imgs->fetch_assoc()): ?>
    <div class="card">
      <img src="/admin/uploads/<?php echo sanitize($g['image']); ?>" alt="img" style="width:100%;height:160px;object-fit:cover">
      <div class="card-body">
        <div><strong><?php echo sanitize($g['team_name'] ?? ''); ?></strong></div>
        <div class="muted"><?php echo sanitize($g['caption']); ?></div>
        <div style="margin-top:8px">
          <a href="/admin/delete-gallery.php?id=<?php echo (int)$g['id']; ?>" onclick="return confirm('Delete image?')">Delete</a>
        </div>
      </div>
    </div>
    <?php endwhile; ?>
  </div>
</div>
</body>
</html>


