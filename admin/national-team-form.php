<?php
require_once __DIR__ . '/../includes/bootstrap.php';
require_login();

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int) $_GET['id'] : null;
$team = ['team_name' => '', 'category' => '', 'banner_image' => ''];
$categories = ['Senior Men', 'Senior Women', 'U18 Men', 'U18 Women', 'U16 Men', 'U16 Women'];
$error = '';
$csrf_token = generate_csrf_token();

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
    require_csrf_token();
    $team_name = trim($_POST['team_name'] ?? '');
    $category = $_POST['category'] ?? '';
    $banner_image = $team['banner_image'];

    // Handle upload
    if (isset($_FILES['banner_image']) && $_FILES['banner_image']['error'] !== UPLOAD_ERR_NO_FILE) {
      $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
      $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
      $uploadError = validate_upload($_FILES['banner_image'], $allowedExts, 5242880, $allowedMimes);
      if ($uploadError) {
        $error = $uploadError;
      } else {
        $ext = strtolower(pathinfo($_FILES['banner_image']['name'], PATHINFO_EXTENSION));
        $filename = generate_safe_filename('national_team', $ext);
        $target = __DIR__ . '/uploads/' . $filename;
        if (!is_dir(__DIR__ . '/uploads/')) {
          mkdir(__DIR__ . '/uploads/', 0755, true);
        }
        if (move_uploaded_file($_FILES['banner_image']['tmp_name'], $target)) {
          $banner_image = $filename;
        } else {
          $error = 'Failed to upload banner image.';
        }
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
  <input type="hidden" name="csrf_token" value="<?php echo sanitize($csrf_token); ?>">
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
