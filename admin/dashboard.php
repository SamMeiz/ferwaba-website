<?php
$page_title = 'Dashboard';
require_once __DIR__ . '/includes/admin-header.php';

// Get stats
$stats = [
  'teams' => $mysqli->query("SELECT COUNT(*) as count FROM teams")->fetch_assoc()['count'],
  'players' => $mysqli->query("SELECT COUNT(*) as count FROM players")->fetch_assoc()['count'],
  'coaches' => $mysqli->query("SELECT COUNT(*) as count FROM coaches")->fetch_assoc()['count'],
  'games' => $mysqli->query("SELECT COUNT(*) as count FROM games")->fetch_assoc()['count'],
  'news' => $mysqli->query("SELECT COUNT(*) as count FROM news")->fetch_assoc()['count'],
  'gallery' => $mysqli->query("SELECT COUNT(*) as count FROM gallery")->fetch_assoc()['count'],
];

// Get recent items
$recent_games = $mysqli->query("SELECT g.*, t1.name as home_team, t2.name as away_team FROM games g LEFT JOIN teams t1 ON g.home_team_id = t1.id LEFT JOIN teams t2 ON g.away_team_id = t2.id ORDER BY g.game_date DESC LIMIT 5");
$recent_news = $mysqli->query("SELECT * FROM news ORDER BY created_at DESC LIMIT 4");
?>

<style>
.dashboard-welcome {
  background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
  border-radius: var(--radius-lg);
  padding: 28px 32px;
  color: #fff;
  margin-bottom: 28px;
}

.dashboard-welcome h2 {
  font-size: 24px;
  font-weight: 700;
  margin-bottom: 6px;
}

.dashboard-welcome p {
  opacity: 0.85;
  font-size: 15px;
}

.quick-links-section {
  margin-bottom: 32px;
}

.section-title {
  font-size: 18px;
  font-weight: 700;
  color: var(--gray-800);
  margin-bottom: 16px;
}

.recent-card {
  background: #fff;
  border-radius: var(--radius-lg);
  box-shadow: var(--shadow);
  overflow: hidden;
}

.recent-card-header {
  padding: 16px 20px;
  border-bottom: 1px solid var(--gray-100);
  display: flex;
  align-items: center;
  justify-content: space-between;
}

.recent-card-header h3 {
  font-size: 15px;
  font-weight: 600;
  color: var(--gray-700);
}

.recent-card-body {
  padding: 0;
}

.recent-item {
  display: flex;
  align-items: center;
  padding: 14px 20px;
  border-bottom: 1px solid var(--gray-100);
  gap: 14px;
}

.recent-item:last-child {
  border-bottom: none;
}

.recent-item:hover {
  background: var(--gray-50);
}

.recent-item-icon {
  width: 40px;
  height: 40px;
  border-radius: 8px;
  background: var(--gray-100);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--primary);
}

.recent-item-content {
  flex: 1;
}

.recent-item-content h4 {
  font-size: 14px;
  font-weight: 600;
  color: var(--gray-800);
  margin-bottom: 2px;
}

.recent-item-content p {
  font-size: 12px;
  color: var(--gray-500);
}

.recent-item-action {
  color: var(--gray-400);
  font-size: 12px;
}

@media (max-width: 768px) {
  .dashboard-welcome {
    padding: 20px;
  }

  .dashboard-welcome h2 {
    font-size: 20px;
  }
}
</style>

<div class="dashboard-welcome">
  <h2>Welcome back, <?php echo sanitize($_SESSION['admin_name'] ?? 'Admin'); ?>!</h2>
  <p>Manage your FERWABA basketball league content from this dashboard.</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
  <a href="teams.php" class="stat-card">
    <div class="stat-icon blue"><i class="fas fa-users"></i></div>
    <div class="stat-content">
      <h3><?php echo number_format($stats['teams']); ?></h3>
      <p>Teams</p>
    </div>
  </a>
  <a href="players.php" class="stat-card">
    <div class="stat-icon green"><i class="fas fa-user-astronaut"></i></div>
    <div class="stat-content">
      <h3><?php echo number_format($stats['players']); ?></h3>
      <p>Players</p>
    </div>
  </a>
  <a href="coaches.php" class="stat-card">
    <div class="stat-icon purple"><i class="fas fa-chalkboard-teacher"></i></div>
    <div class="stat-content">
      <h3><?php echo number_format($stats['coaches']); ?></h3>
      <p>Coaches</p>
    </div>
  </a>
  <a href="games.php" class="stat-card">
    <div class="stat-icon orange"><i class="fas fa-calendar-alt"></i></div>
    <div class="stat-content">
      <h3><?php echo number_format($stats['games']); ?></h3>
      <p>Games</p>
    </div>
  </a>
  <a href="news.php" class="stat-card">
    <div class="stat-icon teal"><i class="fas fa-newspaper"></i></div>
    <div class="stat-content">
      <h3><?php echo number_format($stats['news']); ?></h3>
      <p>News Articles</p>
    </div>
  </a>
  <a href="gallery.php" class="stat-card">
    <div class="stat-icon red"><i class="fas fa-images"></i></div>
    <div class="stat-content">
      <h3><?php echo number_format($stats['gallery']); ?></h3>
      <p>Gallery Items</p>
    </div>
  </a>
</div>

<!-- Management Grid -->
<div class="section-title" style="margin-top: 32px;">Quick Management</div>
<div class="dashboard-grid">
  <a href="teams.php" class="dashboard-card">
    <div class="icon-wrapper"><i class="fas fa-users"></i></div>
    <h3>Manage Teams</h3>
    <p>Add, edit, or remove teams</p>
  </a>
  <a href="players.php" class="dashboard-card">
    <div class="icon-wrapper"><i class="fas fa-user-astronaut"></i></div>
    <h3>Manage Players</h3>
    <p>Player roster management</p>
  </a>
  <a href="games.php" class="dashboard-card">
    <div class="icon-wrapper"><i class="fas fa-calendar-alt"></i></div>
    <h3>Manage Games</h3>
    <p>Schedule and results</p>
  </a>
  <a href="standings-list.php" class="dashboard-card">
    <div class="icon-wrapper"><i class="fas fa-list-ol"></i></div>
    <h3>Standings</h3>
    <p>League standings</p>
  </a>
  <a href="playoffs.php" class="dashboard-card">
    <div class="icon-wrapper"><i class="fas fa-trophy"></i></div>
    <h3>Playoffs</h3>
    <p>Playoff brackets</p>
  </a>
  <a href="news.php" class="dashboard-card">
    <div class="icon-wrapper"><i class="fas fa-newspaper"></i></div>
    <h3>News</h3>
    <p>Latest announcements</p>
  </a>
  <a href="shop.php" class="dashboard-card">
    <div class="icon-wrapper"><i class="fas fa-shopping-bag"></i></div>
    <h3>Shop</h3>
    <p>Merchandise management</p>
  </a>
  <a href="gallery.php" class="dashboard-card">
    <div class="icon-wrapper"><i class="fas fa-images"></i></div>
    <h3>Gallery</h3>
    <p>Photos and media</p>
  </a>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
