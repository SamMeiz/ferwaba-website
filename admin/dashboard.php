<?php
$page_title = 'Dashboard Overview';
require_once __DIR__ . '/includes/admin-header.php';

$security_message = '';
$security_message_type = 'message-success';
$csrf_token = generate_csrf_token();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['lock_admin_id'])) {
  $token = $_POST['csrf_token'] ?? '';
  if (!verify_csrf_token($token)) {
    $security_message = 'Invalid request. Please try again.';
    $security_message_type = 'message-error';
  } elseif (current_admin_role() !== 'SuperAdmin') {
    $security_message = 'Only SuperAdmin can change admin status.';
    $security_message_type = 'message-error';
  } else {
    $targetId = (int) $_POST['lock_admin_id'];
    $setActive = isset($_POST['set_active']) ? (int) $_POST['set_active'] : 0;
    if ($targetId === (int) ($_SESSION['admin_id'] ?? 0)) {
      $security_message = 'You cannot change your own account status.';
      $security_message_type = 'message-error';
    } else {
      $stmt = $db->prepare("SELECT full_name, email FROM admins WHERE id=? LIMIT 1");
      $stmt->execute([$targetId]);
      $targetAdmin = $stmt->fetch();
      $update = $db->prepare("UPDATE admins SET is_active=? WHERE id=? LIMIT 1");
      if ($update->execute([$setActive, $targetId])) {
        $action = $setActive === 1 ? 'Unlock Admin' : 'Lock Admin';
        $details = $targetAdmin ? $targetAdmin['full_name'] . ' (' . $targetAdmin['email'] . ')' : ('ID: ' . $targetId);
        audit_log($db, $action, $details);
        $security_message = $setActive === 1 ? 'Admin unlocked successfully.' : 'Admin locked successfully.';
        $security_message_type = 'message-success';
      } else {
        $security_message = 'Failed to update admin status.';
        $security_message_type = 'message-error';
      }
    }
  }
}

// Get stats using PDO
$stats = [
  'teams' => $db->query("SELECT COUNT(*) FROM teams")->fetchColumn(),
  'players' => $db->query("SELECT COUNT(*) FROM players")->fetchColumn(),
  'coaches' => $db->query("SELECT COUNT(*) FROM coaches")->fetchColumn(),
  'games' => $db->query("SELECT COUNT(*) FROM games")->fetchColumn(),
  'news' => $db->query("SELECT COUNT(*) FROM news")->fetchColumn(),
  'gallery' => $db->query("SELECT COUNT(*) FROM gallery")->fetchColumn(),
];

// Get recent games using PDO
$recent_games = $db->query("
  SELECT g.*, t1.name as home_name, t2.name as away_name 
  FROM games g 
  LEFT JOIN teams t1 ON g.home_team_id = t1.id 
  LEFT JOIN teams t2 ON g.away_team_id = t2.id 
  ORDER BY g.game_date DESC, g.id DESC 
  LIMIT 5
")->fetchAll();

// Get latest news
$latest_news = $db->query("SELECT * FROM news ORDER BY created_at DESC LIMIT 5")->fetchAll();

// Get new players
$new_players = $db->query("SELECT p.*, t.name as team_name FROM players p LEFT JOIN teams t ON p.team_id = t.id ORDER BY p.id DESC LIMIT 5")->fetchAll();

$recent_login_attempts = [];
$top_ip_attempts = [];
$failed_login_logs = [];
try {
  $recent_login_attempts = $db->query("SELECT ip_address, attempt_time, is_successful FROM login_attempts ORDER BY attempt_time DESC LIMIT 10")->fetchAll();
  $top_ip_attempts = $db->query("SELECT ip_address, COUNT(*) AS attempts, SUM(is_successful=0) AS failed_attempts, MAX(attempt_time) AS last_seen FROM login_attempts WHERE attempt_time > DATE_SUB(NOW(), INTERVAL 24 HOUR) GROUP BY ip_address ORDER BY failed_attempts DESC, attempts DESC LIMIT 6")->fetchAll();
  $failed_login_logs = $db->query("SELECT details, ip_address, created_at FROM audit_logs WHERE action='Failed Login' ORDER BY created_at DESC LIMIT 10")->fetchAll();
} catch (PDOException $e) {
  error_log("Security dashboard query failed: " . $e->getMessage());
}
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

<?php if ($security_message): ?>
  <div class="message <?php echo $security_message_type; ?>">
    <i class="fas fa-shield-alt"></i>
    <?php echo sanitize($security_message); ?>
  </div>
<?php endif; ?>

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
        <?php if ($recent_games && count($recent_games) > 0): ?>
          <?php foreach ($recent_games as $game): ?>
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
          <?php endforeach; ?>
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
        <?php if (count($latest_news) > 0): ?>
          <?php foreach ($latest_news as $news): ?>
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
          <?php endforeach; ?>
        <?php else: ?>
          <div class="activity-item">
            <p class="text-muted">No news articles found.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="activity-card" style="margin-top: 32px;">
      <div class="activity-header">
        <h3><i class="fas fa-shield-alt"></i> Security Monitoring</h3>
      </div>
      <div class="activity-list">
        <?php if ($failed_login_logs && count($failed_login_logs) > 0): ?>
          <?php foreach ($failed_login_logs as $log): ?>
            <?php
            $email = '';
            $admin = null;
            if (!empty($log['details']) && preg_match('~:\s*(.+)$~', $log['details'], $match)) {
              $email = trim($match[1]);
            }
            if ($email && filter_var($email, FILTER_VALIDATE_EMAIL)) {
              $stmt = $db->prepare("SELECT id, full_name, is_active FROM admins WHERE email=? LIMIT 1");
              $stmt->execute([$email]);
              $admin = $stmt->fetch();
            }
            ?>
            <div class="activity-item">
              <div class="item-icon" style="background: #fff5f5; color: var(--danger);">
                <i class="fas fa-user-shield"></i>
              </div>
              <div class="item-details">
                <h4><?php echo sanitize($log['details'] ?? 'Failed login attempt'); ?></h4>
                <p><?php echo sanitize($log['ip_address'] ?? ''); ?> •
                  <?php echo date('M d, Y H:i', strtotime($log['created_at'])); ?></p>
                <?php if ($admin): ?>
                  <p style="font-size: 12px; color: var(--gray-600);">
                    <?php echo sanitize($admin['full_name']); ?> (<?php echo sanitize($email); ?>)
                  </p>
                <?php endif; ?>
              </div>
              <?php if ($admin && current_admin_role() === 'SuperAdmin'): ?>
                <form method="post" style="margin-left: 12px;">
                  <input type="hidden" name="csrf_token" value="<?php echo sanitize($csrf_token); ?>">
                  <input type="hidden" name="lock_admin_id" value="<?php echo (int) $admin['id']; ?>">
                  <input type="hidden" name="set_active" value="<?php echo $admin['is_active'] ? 0 : 1; ?>">
                  <button type="submit"
                    class="btn <?php echo $admin['is_active'] ? 'btn-danger' : 'btn-success'; ?> btn-small">
                    <?php echo $admin['is_active'] ? 'Lock' : 'Unlock'; ?>
                  </button>
                </form>
              <?php endif; ?>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="activity-item">
            <p class="text-muted">No failed login activity recorded.</p>
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
        <?php if (count($new_players) > 0): ?>
          <?php foreach ($new_players as $player): ?>
            <div class="activity-item" style="padding: 14px 24px;">
              <div class="item-details">
                <h4 style="font-size: 14px;"><?php echo sanitize($player['name']); ?></h4>
                <p style="font-size: 11px;"><?php echo sanitize($player['team_name'] ?? 'Free Agent'); ?></p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="activity-item">
            <p class="text-muted" style="font-size: 12px;">No recent athlete registrations.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>

    <div class="activity-card" style="margin-top: 32px;">
      <div class="activity-header" style="padding: 18px 24px;">
        <h3 style="font-size: 15px;"><i class="fas fa-network-wired"></i> Top IP Attempts (24h)</h3>
      </div>
      <div class="activity-list">
        <?php if ($top_ip_attempts && count($top_ip_attempts) > 0): ?>
          <?php foreach ($top_ip_attempts as $ip): ?>
            <div class="activity-item" style="padding: 14px 24px;">
              <div class="item-details">
                <h4 style="font-size: 14px;"><?php echo sanitize($ip['ip_address']); ?></h4>
                <p style="font-size: 11px;">
                  <?php echo (int) $ip['failed_attempts']; ?> failed • <?php echo (int) $ip['attempts']; ?> total
                  • Last: <?php echo date('M d, H:i', strtotime($ip['last_seen'])); ?>
                </p>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <div class="activity-item">
            <p class="text-muted" style="font-size: 12px;">No recent IP activity found.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
