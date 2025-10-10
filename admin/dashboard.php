<?php require_once __DIR__ . '/../includes/config.php';
require_login();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
</head>
<body>
<div class="container" style="margin:20px auto">
  <div class="section-title">
    <h2>Dashboard</h2>
    <div>
      <a class="btn" href="/admin/logout.php">Logout</a>
    </div>
  </div>
  <div class="grid col-3">
    <a class="card" href="<?php echo asset_url('/admins.php'); ?>"><div class="card-body"><h3>Manage Admins</h3><p class="muted">SuperAdmin only</p></div></a>
    <a class="card" href="<?php echo asset_url('/teams.php'); ?>"><div class="card-body"><h3>Manage Teams</h3></div></a>
    <a class="card" href="<?php echo asset_url('/players.php'); ?>"><div class="card-body"><h3>Manage Players</h3></div></a>
    <a class="card" href="<?php echo asset_url('/coaches.php'); ?>"><div class="card-body"><h3>Manage Coaches</h3></div></a>
    <a class="card" href="<?php echo asset_url('/games.php'); ?>"><div class="card-body"><h3>Manage Games</h3></div></a>
    <a class="card" href="<?php echo asset_url('/standings.php'); ?>"><div class="card-body"><h3>Manage Standings</h3></div></a>
    <a class="card" href="<?php echo asset_url('/playoffs.php'); ?>"><div class="card-body"><h3>Manage Playoffs</h3></div></a>
    <a class="card" href="<?php echo asset_url('/news.php'); ?>"><div class="card-body"><h3>Manage News</h3></div></a>
    <a class="card" href="<?php echo asset_url('/shop.php'); ?>"><div class="card-body"><h3>Manage Shop</h3></div></a>
    <a class="card" href="<?php echo asset_url('/gallery.php'); ?>"><div class="card-body"><h3>Manage Gallery</h3></div></a>
    <a class="card" href="<?php echo asset_url('/national-teams.php'); ?>"><div class="card-body"><h3>Manage National Teams</h3></div></a>
</div>
</div>
</body>
</html>


