<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int) $_GET['id'] : null;
$team = ['team_name' => '', 'category' => '', 'banner_image' => ''];
$categories = ['Senior Men', 'Senior Women', 'U18 Men', 'U18 Women', 'U16 Men', 'U16 Women'];
$error = '';

try {
  if ($id) {
    $stmt = $db->prepare("SELECT * FROM national_teams WHERE id=?");
    $stmt->execute([$id]);
    $team = $stmt->fetch();
    if (!$team) {
      die('National team not found');
    }
  }

  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $team_name = trim($_POST['team_name'] ?? '');
    $category = $_POST['category'] ?? '';
    $banner_image = $team['banner_image'];

    // Handle upload
    if (!empty($_FILES['banner_image']['name']) && $_FILES['banner_image']['error'] === UPLOAD_ERR_OK) {
      $filename = time() . '_' . bin2hex(random_bytes(4)) . '_' . basename($_FILES['banner_image']['name']);
      $target = __DIR__ . '/uploads/' . $filename;
      if (!is_dir(__DIR__ . '/uploads/'))
        mkdir(__DIR__ . '/uploads/', 0755, true);
      if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $target)) {
        $banner_image = $filename;
      }
    }

    if ($id) {
      $stmt = $db->prepare("UPDATE national_teams SET team_name=?, category=?, banner_image=? WHERE id=?");
      $stmt->execute([$team_name, $category, $banner_image, $id]);
      audit_log($db, 'Edit National Team', "Updated national team: $team_name (ID: $id)");
    } else {
      $stmt = $db->prepare("INSERT INTO national_teams (team_name, category, banner_image) VALUES (?,?,?)");
      $stmt->execute([$team_name, $category, $banner_image]);
      $newId = $db->lastInsertId();
      audit_log($db, 'Add National Team', "Created national team: $team_name (ID: $newId)");
    }

    redirect('national-teams.php');
  }
} catch (PDOException $e) {
  error_log("National Team Form Error: " . $e->getMessage());
  $error = 'A database error occurred.';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <link rel="stylesheet" href="<?php echo asset_url('../css/admin.css'); ?>">
</head>

<section class="section-title">
  <h2><?php echo $id ? 'Edit National Team' : 'Add National Team'; ?></h2>
</section>

<form method="post" enctype="multipart/form-data" class="card" style="max-width:600px;">
  <label>Team Name</label>
  <input type="text" name="team_name" required value="<?php echo sanitize($team['team_name']); ?>">

  <label>Category</label>
  <select name="category" required>
    <?php foreach ($categories as $c): ?>
      <option value="<?php echo $c; ?>" <?php echo ($team['category'] == $c) ? 'selected' : ''; ?>><?php echo $c; ?>
      </option>
    <?php endforeach; ?>
  </select>

  <label>Banner Image</label>
  <input type="file" name="banner_image" accept="image/*">
  <?php if ($team['banner_image']): ?>
    <img src="uploads/<?php echo sanitize($team['banner_image']); ?>"
      style="width:150px;margin-top:8px;border-radius:6px;">
  <?php endif; ?>

  <button type="submit" class="btn">Save Team</button>
</form>