<?php require_once __DIR__ . '/../includes/config.php';
require_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/admin.css'); ?>">
</head>
<body>
<div class="container" style="margin:20px auto">
  <div class="section-title">
    <h2>Dashboard</h2>
    <div>
      <?php if (current_admin_role() === 'SuperAdmin'): ?>
        <a class="btn btn-secondary" href="change-password.php" style="margin-right:8px">Change Password</a>
      <?php endif; ?>
      <a class="btn btn-danger" href="logout.php">Logout</a>
    </div>
  </div>
  <div class="dashboard-grid">
    <a class="dashboard-card" href="admins.php"><h3>Manage Admins</h3><p class="muted">SuperAdmin only</p></a>
    <a class="dashboard-card" href="teams.php"><h3>Manage Teams</h3></a>
    <a class="dashboard-card" href="players.php"><h3>Manage Players</h3></a>
    <a class="dashboard-card" href="coaches.php"><h3>Manage Coaches</h3></a>
    <a class="dashboard-card" href="games.php"><h3>Manage Games</h3></a>
    <a class="dashboard-card" href="standings-list.php"><h3>Manage Standings</h3></a>
    <a class="dashboard-card" href="playoffs.php"><h3>Manage Playoffs</h3></a>
    <a class="dashboard-card" href="news.php"><h3>Manage News</h3></a>
    <a class="dashboard-card" href="shop.php"><h3>Manage Shop</h3></a>
    <a class="dashboard-card" href="gallery.php"><h3>Manage Gallery</h3></a>
    <a class="dashboard-card" href="national-teams.php"><h3>Manage National Teams</h3></a>
    <a class="dashboard-card" href="national-players.php"><h3>Manage National Players</h3></a>
    <a class="dashboard-card" href="stats-list.php"><h3>Manage Player Statistics</h3></a>
  </div>
</div>
</body>
</html>


