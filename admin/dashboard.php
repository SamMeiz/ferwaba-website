<?php
$page_title = 'Dashboard Overview';
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

// Get recent games
$recent_games = $mysqli->query("
  SELECT g.*, t1.name as home_name, t2.name as away_name 
  FROM games g 
  LEFT JOIN teams t1 ON g.home_team_id = t1.id 
  LEFT JOIN teams t2 ON g.away_team_id = t2.id 
  ORDER BY g.game_date DESC, g.id DESC 
  LIMIT 5
");

if (!$recent_games) {
  // Fallback or error handling
  $recent_games = false;
  // You might want to log this error: $mysqli->error
}

// Get latest news
$latest_news = $mysqli->query("SELECT * FROM news ORDER BY created_at DESC LIMIT 5");

// Get new players (recent registrations)
$new_players = $mysqli->query("SELECT p.*, t.name as team_name FROM players p LEFT JOIN teams t ON p.team_id = t.id ORDER BY p.id DESC LIMIT 5");
?>

<style>
  .dash-layout {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 32px;
    margin-top: 32px;
  }

  /* Welcome Card */
  .welcome-banner {
    background: linear-gradient(135deg, var(--primary-dark) 0%, var(--primary) 100%);
    border-radius: var(--radius-xl);
    padding: 40px;
    color: #fff;
    position: relative;
    overflow: hidden;
    box-shadow: var(--shadow-xl);
    margin-bottom: 32px;
  }

  .welcome-banner::after {
    content: '';
    position: absolute;
    top: -20%;
    right: -10%;
    width: 300px;
    height: 300px;
    background: radial-gradient(circle, rgba(255, 255, 255, 0.1) 0%, transparent 70%);
    border-radius: 50%;
  }

  .welcome-content {
    position: relative;
    z-index: 1;
  }

  .welcome-content h2 {
    font-size: 32px;
    font-weight: 800;
    margin-bottom: 12px;
    letter-spacing: -1px;
  }

  .welcome-content p {
    font-size: 16px;
    opacity: 0.9;
    max-width: 600px;
    line-height: 1.6;
  }

  /* Activity Cards */
  .activity-card {
    background: #fff;
    border-radius: var(--radius-lg);
    border: 2px solid var(--gray-200);
    overflow: hidden;
    box-shadow: var(--shadow);
    height: 100%;
  }

  .activity-header {
    padding: 24px;
    border-bottom: 2px solid var(--gray-100);
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: var(--gray-50);
  }

  .activity-header h3 {
    font-size: 17px;
    font-weight: 700;
    color: var(--gray-900);
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .activity-header h3 i {
    color: var(--primary);
  }

  .activity-list {
    padding: 0;
  }

  .activity-item {
    padding: 20px 24px;
    border-bottom: 1px solid var(--gray-100);
    display: flex;
    align-items: center;
    gap: 16px;
    transition: var(--transition);
  }

  .activity-item:last-child {
    border-bottom: none;
  }

  .activity-item:hover {
    background: var(--gray-50);
  }

  .item-icon {
    width: 48px;
    height: 48px;
    border-radius: var(--radius-md);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 18px;
    flex-shrink: 0;
  }

  .item-details {
    flex: 1;
  }

  .item-details h4 {
    font-size: 15px;
    font-weight: 700;
    color: var(--gray-800);
    margin-bottom: 4px;
  }

  .item-details p {
    font-size: 13px;
    color: var(--gray-500);
  }

  /* Game Results Style */
  .game-score-badge {
    background: var(--gray-100);
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 700;
    color: var(--gray-700);
  }

  /* Quick Actions */
  .quick-actions {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .action-btn {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 20px;
    background: #fff;
    border-radius: var(--radius-lg);
    border: 2px solid var(--gray-200);
    text-decoration: none;
    color: var(--gray-800);
    font-weight: 700;
    transition: var(--transition);
    box-shadow: var(--shadow-sm);
  }

  .action-btn:hover {
    border-color: var(--primary);
    transform: translateX(8px);
    box-shadow: var(--shadow-md);
    color: var(--primary);
  }

  .action-btn i {
    width: 40px;
    height: 40px;
    background: var(--gray-100);
    border-radius: 10px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: var(--transition);
  }

  .action-btn:hover i {
    background: var(--primary);
    color: #fff;
  }

  @media (max-width: 1200px) {
    .dash-layout {
      grid-template-columns: 1fr;
    }
  }
</style>

<div class="welcome-banner">
  <div class="welcome-content">
    <h2>Morning, <?php echo explode(' ', sanitize($admin_name))[0]; ?>!</h2>
    <p>Your basketball ecosystem is performing well. You have <strong><?php echo $stats['games']; ?></strong> scheduled
      games and <strong><?php echo $stats['news']; ?></strong> published articles. Here's what's happening today.</p>
  </div>
</div>

<!-- Stats Bar -->
<div class="stats-grid">
  <div class="stat-card">
    <div class="stat-icon blue"><i class="fas fa-users"></i></div>
    <div class="stat-content">
      <h3><?php echo number_format($stats['teams']); ?></h3>
      <p>Clubs</p>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon green"><i class="fas fa-user-astronaut"></i></div>
    <div class="stat-content">
      <h3><?php echo number_format($stats['players']); ?></h3>
      <p>Athletes</p>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon orange"><i class="fas fa-basketball-ball"></i></div>
    <div class="stat-content">
      <h3><?php echo number_format($stats['games']); ?></h3>
      <p>Fixtures</p>
    </div>
  </div>
  <div class="stat-card">
    <div class="stat-icon teal"><i class="fas fa-newspaper"></i></div>
    <div class="stat-content">
      <h3><?php echo number_format($stats['news']); ?></h3>
      <p>Updates</p>
    </div>
  </div>
</div>

<div class="dash-layout">
  <!-- Main Column -->
  <div class="main-col">
    <div class="activity-card">
      <div class="activity-header">
        <h3><i class="fas fa-history"></i> Recent Game Results</h3>
        <a href="games" class="btn btn-secondary btn-sm">View All</a>
      </div>
      <div class="activity-list">
        <?php if ($recent_games && $recent_games->num_rows > 0): ?>
          <?php while ($game = $recent_games->fetch_assoc()): ?>
            <div class="activity-item">
              <div class="item-icon" style="background: var(--gray-100); color: var(--primary);">
                <i class="fas fa-gamepad"></i>
              </div>
              <div class="item-details">
                <h4><?php echo sanitize($game['home_name']); ?> vs <?php echo sanitize($game['away_name']); ?></h4>
                <p><?php echo date('M d, Y', strtotime($game['game_date'])); ?> •
                  <?php echo sanitize($game['location'] ?? ''); ?>
                </p>
              </div>
              <div class="game-score-badge">
                <?php if ($game['status'] === 'Completed'): ?>
                  <?php echo $game['home_score']; ?> - <?php echo $game['away_score']; ?>
                <?php else: ?>
                  <?php echo sanitize($game['status']); ?>
                <?php endif; ?>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="activity-item">
            <p class="text-muted">No recent games recorded.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="activity-card" style="margin-top: 32px;">
      <div class="activity-header">
        <h3><i class="fas fa-newspaper"></i> Latest News Articles</h3>
        <a href="news" class="btn btn-secondary btn-sm">Manage</a>
      </div>
      <div class="activity-list">
        <?php if ($latest_news->num_rows > 0): ?>
          <?php while ($news = $latest_news->fetch_assoc()): ?>
            <div class="activity-item">
              <div class="item-icon" style="background: var(--gray-100); color: var(--secondary);">
                <i class="fas fa-bullhorn"></i>
              </div>
              <div class="item-details">
                <h4><?php echo sanitize($news['title']); ?></h4>
                <p>Published on <?php echo date('M d, Y', strtotime($news['created_at'])); ?></p>
              </div>
              <a href="news-form?id=<?php echo $news['id']; ?>" class="btn btn-icon btn-sm" title="Edit Article">
                <i class="fas fa-edit"></i>
              </a>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="activity-item">
            <p class="text-muted">No news articles found.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Sidebar Column -->
  <div class="side-col">
    <h3 class="section-title" style="margin-top: 0; font-size: 16px; text-transform: uppercase; letter-spacing: 1px;">
      System Shortcuts</h3>
    <div class="quick-actions">
      <a href="news-form" class="action-btn">
        <i class="fas fa-plus"></i>
        <span>Post New Update</span>
      </a>
      <a href="game-form" class="action-btn">
        <i class="fas fa-calendar-plus"></i>
        <span>Schedule Fixture</span>
      </a>
      <a href="player-form" class="action-btn">
        <i class="fas fa-user-plus"></i>
        <span>Register Athlete</span>
      </a>
      <a href="team-form" class="action-btn">
        <i class="fas fa-users-cog"></i>
        <span>Add New Club</span>
      </a>
    </div>

    <div class="activity-card" style="margin-top: 32px;">
      <div class="activity-header" style="padding: 18px 24px;">
        <h3 style="font-size: 15px;"><i class="fas fa-user-clock"></i> Recent Signups</h3>
      </div>
      <div class="activity-list">
        <?php if ($new_players->num_rows > 0): ?>
          <?php while ($player = $new_players->fetch_assoc()): ?>
            <div class="activity-item" style="padding: 14px 24px;">
              <div class="item-details">
                <h4 style="font-size: 14px;"><?php echo sanitize($player['name']); ?></h4>
                <p style="font-size: 11px;"><?php echo sanitize($player['team_name'] ?? 'Free Agent'); ?></p>
              </div>
            </div>
          <?php endwhile; ?>
        <?php else: ?>
          <div class="activity-item">
            <p class="text-muted" style="font-size: 12px;">No recent athlete registrations.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>