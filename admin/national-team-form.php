<?php
require_once __DIR__ . '/../includes/config.php';
require_login();

$id = $_GET['id'] ?? null;
$team = ['team_name'=>'','category'=>'','banner_image'=>''];
$categories = ['Senior Men','Senior Women','U18 Men','U18 Women','U16 Men','U16 Women'];

if ($id) {
  $stmt = $mysqli->prepare("SELECT * FROM national_teams WHERE id=?");
  $stmt->bind_param('i', $id);
  $stmt->execute();
  $team = $stmt->get_result()->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $team_name = trim($_POST['team_name']);
  $category = $_POST['category'];
  $banner_image = $team['banner_image'];

  // Handle upload
  if (!empty($_FILES['banner_image']['name'])) {
    $filename = time().'_'.basename($_FILES['banner_image']['name']);
    $target = __DIR__ . '/uploads/' . $filename;
    move_uploaded_file($_FILES['banner_image']['tmp_name'], $target);
    $banner_image = $filename;
  }

  if ($id) {
    $stmt = $mysqli->prepare("UPDATE national_teams SET team_name=?, category=?, banner_image=? WHERE id=?");
    $stmt->bind_param('sssi', $team_name, $category, $banner_image, $id);
  } else {
    $stmt = $mysqli->prepare("INSERT INTO national_teams (team_name, category, banner_image) VALUES (?,?,?)");
    $stmt->bind_param('sss', $team_name, $category, $banner_image);
  }

  $stmt->execute();
  header("Location: national-teams.php");
  exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>

<section class="section-title">
  <h2><?php echo $id ? 'Edit National Team' : 'Add National Team'; ?></h2>
</section>

<form method="post" enctype="multipart/form-data" class="card" style="max-width:600px;">
  <label>Team Name</label>
  <input type="text" name="team_name" required value="<?php echo sanitize($team['team_name']); ?>">

  <label>Category</label>
  <select name="category" required>
    <?php foreach($categories as $c): ?>
      <option value="<?php echo $c; ?>" <?php echo ($team['category']==$c)?'selected':''; ?>><?php echo $c; ?></option>
    <?php endforeach; ?>
  </select>

  <label>Banner Image</label>
  <input type="file" name="banner_image" accept="image/*">
  <?php if ($team['banner_image']): ?>
    <img src="uploads/<?php echo sanitize($team['banner_image']); ?>" style="width:150px;margin-top:8px;border-radius:6px;">
  <?php endif; ?>

  <button type="submit" class="btn">Save Team</button>
</form>


