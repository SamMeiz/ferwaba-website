<?php
require_once __DIR__ . '/../../includes/bootstrap.php';
require_login();
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$admin_name = $_SESSION['admin_name'] ?? 'Admin';
$admin_role = $_SESSION['admin_role'] ?? 'Admin';
$mysqli = $mysqli ?? $GLOBALS['mysqli'] ?? null;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>FERWABA Admin</title>
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="../assets/css/admin-enhancements.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="admin-body">
  <!-- Top Navigation Header -->
  <header class="admin-header">
    <div class="header-top">
      <div class="brand">
        <div class="logo">
          <i class="fas fa-basketball-ball"></i>
          <span>FERWABA</span>
        </div>
        <span class="logo-badge">Admin Panel</span>
      </div>

      <div class="header-actions">
        <div class="admin-user-profile">
          <div class="user-info">
            <span class="name"><?php echo sanitize($admin_name); ?></span>
            <span class="role"><?php echo sanitize($admin_role); ?></span>
          </div>
          <div class="user-avatar">
            <i class="fas fa-user-circle"></i>
          </div>
        </div>
        <a href="logout" class="btn-logout" title="Logout">
          <i class="fas fa-sign-out-alt"></i>
        </a>
      </div>
    </div>

    <nav class="horizontal-nav">
      <div class="nav-scroll-container">
        <a href="dashboard" class="nav-link <?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">
          <i class="fas fa-home"></i> <span>Dashboard</span>
        </a>
        <a href="teams" class="nav-link <?php echo $current_page === 'teams' ? 'active' : ''; ?>">
          <i class="fas fa-users"></i> <span>Teams</span>
        </a>
        <a href="players" class="nav-link <?php echo $current_page === 'players' ? 'active' : ''; ?>">
          <i class="fas fa-user-astronaut"></i> <span>Players</span>
        </a>
        <a href="games" class="nav-link <?php echo $current_page === 'games' ? 'active' : ''; ?>">
          <i class="fas fa-calendar-alt"></i> <span>Games</span>
        </a>
        <a href="news" class="nav-link <?php echo $current_page === 'news' ? 'active' : ''; ?>">
          <i class="fas fa-newspaper"></i> <span>News</span>
        </a>

        <div class="nav-divider"></div>

        <a href="coaches" class="nav-link <?php echo $current_page === 'coaches' ? 'active' : ''; ?>">
          <i class="fas fa-chalkboard-teacher"></i> <span>Coaches</span>
        </a>
        <a href="standings-list" class="nav-link <?php echo $current_page === 'standings-list' ? 'active' : ''; ?>">
          <i class="fas fa-list-ol"></i> <span>Standings</span>
        </a>
        <a href="playoffs" class="nav-link <?php echo $current_page === 'playoffs' ? 'active' : ''; ?>">
          <i class="fas fa-trophy"></i> <span>Playoffs</span>
        </a>
        <a href="gallery" class="nav-link <?php echo $current_page === 'gallery' ? 'active' : ''; ?>">
          <i class="fas fa-images"></i> <span>Gallery</span>
        </a>
        <a href="shop" class="nav-link <?php echo $current_page === 'shop' ? 'active' : ''; ?>">
          <i class="fas fa-shopping-bag"></i> <span>Shop</span>
        </a>

        <div class="nav-divider"></div>

        <a href="national-teams" class="nav-link <?php echo $current_page === 'national-teams' ? 'active' : ''; ?>">
          <i class="fas fa-flag"></i> <span>Nat. Teams</span>
        </a>
        <a href="stats-list" class="nav-link <?php echo $current_page === 'stats-list' ? 'active' : ''; ?>">
          <i class="fas fa-chart-bar"></i> <span>Stats</span>
        </a>

        <?php if ($admin_role === 'SuperAdmin'): ?>
          <a href="admins" class="nav-link <?php echo $current_page === 'admins' ? 'active' : ''; ?>">
            <i class="fas fa-user-shield"></i> <span>Admins</span>
          </a>
        <?php endif; ?>
      </div>
    </nav>
  </header>

  <!-- Main Content -->
  <main class="admin-main">
    <div class="admin-content">
