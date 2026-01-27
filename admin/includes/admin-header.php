<?php
require_once __DIR__ . '/../../includes/config.php';
require_login();
$current_page = basename($_SERVER['PHP_SELF'], '.php');
$admin_name = $_SESSION['admin_name'] ?? 'Admin';
$admin_role = $_SESSION['admin_role'] ?? 'Admin';
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>FERWABA Admin</title>
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="admin-body">
  <!-- Sidebar -->
  <aside class="admin-sidebar" id="adminSidebar">
    <div class="sidebar-header">
      <div class="logo">
        <i class="fas fa-basketball-ball"></i>
        <span>FERWABA</span>
      </div>
      <span class="logo-badge">Management System</span>
      <p
        style="font-size: 10px; color: rgba(255,255,255,0.5); margin-top: 8px; text-align: center; letter-spacing: 0.5px;">
        Rwanda Basketball Federation</p>
    </div>

    <nav class="sidebar-nav">
      <a href="dashboard.php" class="nav-item <?php echo $current_page === 'dashboard' ? 'active' : ''; ?>">
        <i class="fas fa-home"></i>
        <span>Dashboard</span>
      </a>

      <div class="nav-section">Management</div>

      <a href="teams.php" class="nav-item <?php echo $current_page === 'teams' ? 'active' : ''; ?>">
        <i class="fas fa-users"></i>
        <span>Teams</span>
      </a>
      <a href="players.php" class="nav-item <?php echo $current_page === 'players' ? 'active' : ''; ?>">
        <i class="fas fa-user-astronaut"></i>
        <span>Players</span>
      </a>
      <a href="coaches.php" class="nav-item <?php echo $current_page === 'coaches' ? 'active' : ''; ?>">
        <i class="fas fa-chalkboard-teacher"></i>
        <span>Coaches</span>
      </a>
      <a href="games.php" class="nav-item <?php echo $current_page === 'games' ? 'active' : ''; ?>">
        <i class="fas fa-calendar-alt"></i>
        <span>Games</span>
      </a>
      <a href="standings-list.php" class="nav-item <?php echo $current_page === 'standings-list' ? 'active' : ''; ?>">
        <i class="fas fa-list-ol"></i>
        <span>Standings</span>
      </a>
      <a href="playoffs.php" class="nav-item <?php echo $current_page === 'playoffs' ? 'active' : ''; ?>">
        <i class="fas fa-trophy"></i>
        <span>Playoffs</span>
      </a>

      <div class="nav-section">Content</div>

      <a href="news.php" class="nav-item <?php echo $current_page === 'news' ? 'active' : ''; ?>">
        <i class="fas fa-newspaper"></i>
        <span>News</span>
      </a>
      <a href="gallery.php" class="nav-item <?php echo $current_page === 'gallery' ? 'active' : ''; ?>">
        <i class="fas fa-images"></i>
        <span>Gallery</span>
      </a>
      <a href="shop.php" class="nav-item <?php echo $current_page === 'shop' ? 'active' : ''; ?>">
        <i class="fas fa-shopping-bag"></i>
        <span>Shop</span>
      </a>

      <div class="nav-section">National Team</div>

      <a href="national-teams.php" class="nav-item <?php echo $current_page === 'national-teams' ? 'active' : ''; ?>">
        <i class="fas fa-flag"></i>
        <span>National Teams</span>
      </a>
      <a href="national-players.php"
        class="nav-item <?php echo $current_page === 'national-players' ? 'active' : ''; ?>">
        <i class="fas fa-user-astronaut"></i>
        <span>National Players</span>
      </a>
      <a href="stats-list.php" class="nav-item <?php echo $current_page === 'stats-list' ? 'active' : ''; ?>">
        <i class="fas fa-chart-bar"></i>
        <span>Statistics</span>
      </a>

      <?php if ($admin_role === 'SuperAdmin'): ?>
        <div class="nav-section">System</div>

        <a href="admins.php" class="nav-item <?php echo $current_page === 'admins' ? 'active' : ''; ?>">
          <i class="fas fa-user-shield"></i>
          <span>Admins</span>
        </a>
      <?php endif; ?>
    </nav>

    <div class="sidebar-footer">
      <a href="change-password.php" class="nav-item <?php echo $current_page === 'change-password' ? 'active' : ''; ?>">
        <i class="fas fa-key"></i>
        <span>Change Password</span>
      </a>
      <a href="logout.php" class="nav-item logout">
        <i class="fas fa-sign-out-alt"></i>
        <span>Logout</span>
      </a>
    </div>
  </aside>

  <!-- Main Content -->
  <main class="admin-main">
    <header class="admin-topbar">
      <div class="page-title">
        <h1><?php echo isset($page_title) ? $page_title : 'Dashboard'; ?></h1>
        <p style="font-size: 12px; color: var(--gray-500); margin-top: 2px; font-weight: 500;">
          <i class="fas fa-calendar-day"></i> <?php echo date('l, F j, Y'); ?> 
          <span style="margin-left: 12px;"><i class="fas fa-clock"></i> <?php echo date('g:i A'); ?></span>
        </p>
      </div>
      <div class="topbar-actions">
        <button class="btn btn-icon btn-secondary" style="background: transparent; border: 2px solid var(--gray-300); color: var(--gray-600); box-shadow: none;" title="Notifications">
          <i class="fas fa-bell"></i>
        </button>
        <span class="admin-user">
          <i class="fas fa-user-circle"></i>
          <div style="display: flex; flex-direction: column; align-items: flex-start; gap: 2px;">
            <span style="font-weight: 700; font-size: 14px;"><?php echo sanitize($admin_name); ?></span>
            <span class="role-badge"><?php echo sanitize($admin_role); ?></span>
          </div>
        </span>
      </div>
    </header>
    <div class="admin-content">