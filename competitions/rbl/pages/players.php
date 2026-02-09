<?php require_once __DIR__ . '/../includes/header.php'; ?>

<style>
  /* Leaderboard Styles */
  .leaderboard-container {
    padding: 60px 0;
  }

  .leaderboard-title {
    text-align: center;
    margin-bottom: 50px;
  }

  .leaderboard-title h1 {
    font-size: 42px;
    font-weight: 800;
    color: #fff;
    text-transform: uppercase;
    margin-bottom: 10px;
    letter-spacing: 1px;
  }

  .leaderboard-title p {
    color: #fbbf24;
    font-size: 16px;
    font-weight: 600;
    letter-spacing: 2px;
    text-transform: uppercase;
  }

  .stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(350px, 1fr));
    gap: 40px;
    max-width: 1400px;
    margin: 0 auto;
    padding: 0 20px;
  }

  .stat-category {
    background: rgba(255, 255, 255, 0.95);
    border-radius: 20px;
    overflow: hidden;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
    display: flex;
    flex-direction: column;
  }

  .stat-header {
    background: linear-gradient(135deg, #1a2a44 0%, #2c5282 100%);
    padding: 20px;
    text-align: center;
    color: #fff;
    position: relative;
  }

  .stat-header h2 {
    margin: 0;
    font-size: 24px;
    font-weight: 800;
    text-transform: uppercase;
  }

  .stat-header span {
    font-size: 12px;
    opacity: 0.8;
    letter-spacing: 1px;
    text-transform: uppercase;
    display: block;
    margin-top: 4px;
  }

  /* 👑 The King/Queen */
  .top-player-spotlight {
    padding: 40px 20px 30px;
    text-align: center;
    background: linear-gradient(to bottom, #f8fafc 0%, #fff 100%);
    position: relative;
    border-bottom: 1px solid #e2e8f0;
  }

  .crown-icon {
    position: absolute;
    top: 20px;
    left: 50%;
    transform: translateX(-50%);
    font-size: 32px;
    color: #fbbf24;
    filter: drop-shadow(0 4px 6px rgba(251, 191, 36, 0.4));
    animation: float 3s ease-in-out infinite;
    z-index: 10;
  }

  @keyframes float {

    0%,
    100% {
      transform: translate(-50%, 0);
    }

    50% {
      transform: translate(-50%, -10px);
    }
  }

  .top-player-img-wrapper {
    width: 120px;
    height: 120px;
    margin: 0 auto 16px;
    position: relative;
    border-radius: 50%;
    padding: 4px;
    background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
    box-shadow: 0 8px 20px rgba(251, 191, 36, 0.3);
  }

  .top-player-img {
    width: 100%;
    height: 100%;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid #fff;
    background: #fff;
  }

  .top-player-name {
    font-size: 20px;
    font-weight: 800;
    color: #1a1a1a;
    margin-bottom: 4px;
  }

  .top-player-team {
    font-size: 13px;
    color: #64748b;
    font-weight: 600;
    text-transform: uppercase;
    margin-bottom: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 6px;
  }

  .top-player-stat {
    display: inline-block;
    background: #1a2a44;
    color: #fbbf24;
    padding: 8px 20px;
    border-radius: 30px;
    font-weight: 800;
    font-size: 24px;
    box-shadow: 0 4px 12px rgba(26, 42, 68, 0.3);
  }

  .top-player-stat span {
    font-size: 12px;
    color: rgba(255, 255, 255, 0.7);
    font-weight: 600;
    margin-left: 4px;
    text-transform: uppercase;
  }

  /* List (2-5) */
  .runners-up-list {
    padding: 10px 0;
  }

  .runner-up-row {
    display: flex;
    align-items: center;
    padding: 15px 20px;
    border-bottom: 1px solid #f1f5f9;
    transition: background 0.2s;
  }

  .runner-up-row:last-child {
    border-bottom: none;
  }

  .runner-up-row:hover {
    background: #f8fafc;
  }

  .rank-badge {
    width: 24px;
    height: 24px;
    background: #e2e8f0;
    color: #64748b;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 700;
    font-size: 11px;
    margin-right: 12px;
  }

  .rank-2 {
    background: #e5e7eb;
    color: #374151;
  }

  .rank-3 {
    background: #e5e7eb;
    color: #374151;
  }

  .runner-info {
    flex-grow: 1;
  }

  .runner-name {
    font-weight: 700;
    font-size: 14px;
    color: #1e293b;
    display: block;
  }

  .runner-team {
    font-size: 11px;
    color: #64748b;
    margin-top: 2px;
  }

  .runner-stat {
    font-weight: 800;
    font-size: 16px;
    color: #1a2a44;
  }

  @media (max-width: 768px) {
    .stats-grid {
      grid-template-columns: 1fr;
      padding: 0 16px;
    }
  }
</style>

<div class="leaderboard-container">
  <div class="leaderboard-title">
    <p>Season 2025/26</p>
    <h1>Statistical Leaders</h1>
  </div>

  <div class="stats-grid">
    <?php
    $categories = [
      'Points' => ['col' => 'total_points', 'label' => 'PPG', 'icon' => 'fa-basketball-ball'],
      'Rebounds' => ['col' => 'total_rebounds', 'label' => 'RPG', 'icon' => 'fa-hand-holding'],
      'Assists' => ['col' => 'total_assists', 'label' => 'APG', 'icon' => 'fa-hands-helping'],
      'Steals' => ['col' => 'total_steals', 'label' => 'SPG', 'icon' => 'fa-hand-rock'],
      'Blocks' => ['col' => 'total_blocks', 'label' => 'BPG', 'icon' => 'fa-hand-paper']
    ];

    foreach ($categories as $title => $meta):
      $col = $meta['col'];
      // Query top 5 players for this stat
      // Calculate average: total_stat / games_played
      // Use LEFT JOIN to ensure we get players even if stats table is empty for them
      $sql = "
        SELECT p.name, p.photo, p.position, t.name AS team_name,
               COALESCE(s.$col, 0) AS total, 
               COALESCE(s.games_played, 0) AS games_played,
               COALESCE(ROUND(s.$col / NULLIF(s.games_played, 0), 1), 0) AS avg_stat
        FROM players p
        JOIN teams t ON t.id = p.team_id
        LEFT JOIN player_stats s ON p.id = s.player_id
        ORDER BY avg_stat DESC, p.name ASC
        LIMIT 5";
      $res = $mysqli->query($sql);

      if ($res && $res->num_rows > 0):
        $players = [];
        while ($row = $res->fetch_assoc()) {
          $players[] = $row;
        }
        $topPlayer = $players[0];
        ?>
        <div class="stat-category">
          <div class="stat-header">
            <h2><?php echo $title; ?></h2>
            <span>Top 5 <?php echo ($title === 'Points') ? 'Scoring Leaders' : $title . ' Leaders'; ?></span>
          </div>

          <!-- 👑 Top Player -->
          <div class="top-player-spotlight">
            <i class="fas fa-crown crown-icon"></i>
            <div class="top-player-img-wrapper">
              <img
                src="<?php echo !empty($topPlayer['photo']) ? '../../../admin/uploads/' . sanitize($topPlayer['photo']) : 'https://via.placeholder.com/150'; ?>"
                alt="<?php echo sanitize($topPlayer['name']); ?>" class="top-player-img">
            </div>
            <div class="top-player-name"><?php echo sanitize($topPlayer['name']); ?></div>
            <div class="top-player-team">
              <i class="fas fa-shield-alt"></i> <?php echo sanitize($topPlayer['team_name']); ?>
            </div>
            <div class="top-player-stat">
              <?php echo $topPlayer['avg_stat']; ?>
              <span><?php echo $meta['label']; ?></span>
            </div>
          </div>

          <!-- Runners Up -->
          <div class="runners-up-list">
            <?php
            for ($i = 1; $i < count($players); $i++):
              $p = $players[$i];
              ?>
              <div class="runner-up-row">
                <div class="rank-badge rank-<?php echo $i + 1; ?>"><?php echo $i + 1; ?></div>
                <div class="runner-info">
                  <span class="runner-name"><?php echo sanitize($p['name']); ?></span>
                  <span class="runner-team"><?php echo sanitize($p['team_name']); ?></span>
                </div>
                <div class="runner-stat"><?php echo $p['avg_stat']; ?></div>
              </div>
            <?php endfor; ?>
          </div>
        </div>
      <?php endif; endforeach; ?>
  </div>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>