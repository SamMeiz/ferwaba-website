<?php 
require_once __DIR__ . '/../includes/config.php';
require_login();

// --- Filters ---
$selectedGender = $_GET['gender'] ?? 'All';
$selectedType   = $_GET['type'] ?? 'All';

// --- Fetch gallery ---
$imgs = $mysqli->query("
    SELECT g.id, g.image, g.caption, 
           t.name AS team_name, t.gender, t.division,
           nt.team_name AS nteam_name, nt.category
    FROM gallery g
    LEFT JOIN teams t ON t.id = g.team_id
    LEFT JOIN national_teams nt ON nt.id = g.team_id
    ORDER BY COALESCE(t.name, nt.team_name) ASC
");

// --- Organize images ---
$galleryByTeam = [];
while($g = $imgs->fetch_assoc()) {
    // Determine source
    $isNational = !empty($g['nteam_name']);
    $team = $isNational ? $g['nteam_name'] : $g['team_name'];
    $gender = $isNational 
        ? (strpos($g['category'], 'Women') !== false ? 'Women' : 'Men') 
        : ($g['gender'] ?? '');
    $type = $isNational ? 'National Teams' : 'Division Teams';

    // Apply filters
    if ($selectedGender !== 'All' && $gender !== $selectedGender) continue;
    if ($selectedType !== 'All' && $type !== $selectedType) continue;

    $galleryByTeam[$team][] = [
        'id' => $g['id'],
        'image' => $g['image'],
        'caption' => $g['caption'],
        'gender' => $gender,
        'type' => $type,
    ];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Gallery - FERWABA</title>
<link rel="stylesheet" href="<?php echo asset_url('css/style.css'); ?>">
<style>
.flex { display:flex; flex-wrap:wrap; gap:8px; }
.card {
  width:18%;
  background:#fff;
  border-radius:10px;
  overflow:hidden;
  box-shadow:0 2px 6px rgba(0,0,0,0.05);
}
.card img {
  width:100%;
  aspect-ratio:1/1;
  object-fit:cover;
  border-radius:6px;
}
.card-body {
  padding:4px;
  text-align:center;
  font-size:11px;
}
.muted { color:#6b7280; font-size:0.75rem; }
.filter-form {
  display:flex;
  gap:12px;
  align-items:center;
  margin-bottom:20px;
}
.filter-form select {
  padding:6px;
  border:1px solid #d1d5db;
  border-radius:6px;
}
</style>
</head>
<body>
<div class="container" style="margin:20px auto">
  <div class="section-title">
    <h2>Gallery</h2>
    <a class="btn" href="<?php echo asset_url('gallery-form.php'); ?>">Upload Photo</a>
    <a href="javascript:history.back()" class="btn" style="background:#6b7280;margin-left:8px;">⬅️ Back</a>
  </div>

  <!-- Filter Form -->
  <form method="get" class="filter-form">
    <label>Gender:</label>
    <select name="gender" onchange="this.form.submit()">
      <option value="All" <?php if($selectedGender==='All') echo 'selected'; ?>>All</option>
      <option value="Men" <?php if($selectedGender==='Men') echo 'selected'; ?>>Men</option>
      <option value="Women" <?php if($selectedGender==='Women') echo 'selected'; ?>>Women</option>
    </select>

    <label>Team Type:</label>
    <select name="type" onchange="this.form.submit()">
      <option value="All" <?php if($selectedType==='All') echo 'selected'; ?>>All</option>
      <option value="Division Teams" <?php if($selectedType==='Division Teams') echo 'selected'; ?>>Division Teams</option>
      <option value="National Teams" <?php if($selectedType==='National Teams') echo 'selected'; ?>>National Teams</option>
    </select>
  </form>

  <!-- Gallery Display -->
  <?php foreach($galleryByTeam as $team => $images): ?>
    <h3 style="margin-top:24px;"><?php echo sanitize($team); ?></h3>
    <div class="flex">
      <?php foreach($images as $g): ?>
        <div class="card">
          <img src="/ferwaba1/admin/uploads/<?php echo sanitize($g['image']); ?>" alt="img">
          <div class="card-body">
            <?php if(!empty($g['caption'])): ?>
              <div class="muted"><?php echo sanitize($g['caption']); ?></div>
            <?php endif; ?>
            <div style="margin-top:2px;">
              <a href="delete-gallery.php?id=<?php echo (int)$g['id']; ?>" 
                 onclick="return confirm('Delete image?')" 
                 style="color:#ef4444;font-size:11px;">Delete</a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>
</div>
</body>
</html>
