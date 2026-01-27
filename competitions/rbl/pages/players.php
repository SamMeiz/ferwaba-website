<?php require_once __DIR__ . '/../includes/header.php'; ?><br><br>

<style>
  /* Professional Player Cards */
  .players-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
  }

  .player-card-pro {
    position: relative;
    background: #fff;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
    transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
    text-decoration: none;
    color: inherit;
    display: block;
  }

  .player-card-pro:hover {
    transform: translateY(-8px);
    box-shadow: 0 16px 35px rgba(0, 0, 0, 0.2);
  }

  .player-card-image {
    position: relative;
    width: 100%;
    height: 280px;
    overflow: hidden;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
  }

  .player-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s ease;
  }

  .player-card-pro:hover .player-card-image img {
    transform: scale(1.1);
  }

  .player-jersey {
    position: absolute;
    top: 16px;
    right: 16px;
    width: 60px;
    height: 60px;
    background: rgba(255, 255, 255, 0.95);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    font-weight: 800;
    color: #2563eb;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
    backdrop-filter: blur(10px);
  }

  .player-card-content {
    padding: 24px;
  }

  .player-name {
    font-size: 22px;
    font-weight: 700;
    margin-bottom: 8px;
    color: #1a1a1a;
  }

  .player-details {
    display: flex;
    flex-direction: column;
    gap: 6px;
    color: #666;
    font-size: 14px;
  }

  .player-detail-item {
    display: flex;
    align-items: center;
    gap: 8px;
  }

  .player-detail-item i {
    color: #2563eb;
    width: 16px;
  }

  .gender-filter-buttons {
    display: flex;
    gap: 12px;
    justify-content: center;
    flex-wrap: wrap;
    margin-top: 20px;
  }

  .gender-btn {
    padding: 10px 28px;
    border-radius: 25px;
    background: #f3f4f6;
    color: #4b5563;
    text-decoration: none;
    font-weight: 600;
    font-size: 15px;
    transition: all 0.3s ease;
    border: 2px solid transparent;
  }

  .gender-btn.active {
    background: #2563eb;
    color: #fff;
    border-color: #2563eb;
  }

  .gender-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3);
  }

  .division-section {
    margin: 60px 0;
  }

  .division-title {
    font-size: 28px;
    font-weight: 800;
    margin-bottom: 30px;
    color: #1a1a1a;
    position: relative;
    padding-bottom: 12px;
  }

  .division-title::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 0;
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #2563eb, #60a5fa);
    border-radius: 2px;
  }

  .view-more-link {
    display: inline-block;
    padding: 12px 32px;
    background: linear-gradient(135deg, #2563eb 0%, #1d4ed8 100%);
    color: #fff;
    border-radius: 30px;
    text-decoration: none;
    font-weight: 600;
    transition: all 0.3s ease;
    box-shadow: 0 6px 20px rgba(37, 99, 235, 0.3);
  }

  .view-more-link:hover {
    transform: translateY(-2px);
    box-shadow: 0 8px 25px rgba(37, 99, 235, 0.4);
  }

  @media (max-width: 768px) {
    .player-card-image {
      height: 240px;
    }
  }
</style>

<section class="section-title">
  <h2>Players</h2>
  <div class="gender-filter-buttons">
    <?php
    $genders = ['All', 'Men', 'Women'];
    $activeGender = $_GET['gender'] ?? 'All';
    foreach ($genders as $g):
      $isActive = ($activeGender === $g) ? 'active' : '';
      ?>
      <a href="?gender=<?php echo urlencode($g); ?>" class="gender-btn <?php echo $isActive; ?>">
        <?php echo $g; ?>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- ===== Division 1 ===== -->
<section class="division-section">
  <h3 class="division-title">Division 1 Players</h3>
  <div class="grid col-3">
    <?php
    $genderFilter = ($activeGender !== 'All') ? "AND t.gender=?" : "";
    $sql = "
      SELECT p.id, p.name, p.position, p.jersey_number, p.photo, t.name AS team_name, t.gender, t.division
      FROM players p
      JOIN teams t ON t.id = p.team_id
      WHERE t.division='Division 1' $genderFilter
      ORDER BY p.name ASC
      LIMIT 9";
    $stmt = $mysqli->prepare($sql);
    if ($genderFilter)
      $stmt->bind_param('s', $activeGender);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($p = $res->fetch_assoc()):
      $photo = !empty($p['photo']) ? '../../../admin/uploads/' . sanitize($p['photo']) : 'https://via.placeholder.com/600x300?text=Player';
      ?>
      <a class="player-card-pro" href="player-card.php?id=<?php echo (int) $p['id']; ?>">
        <div class="player-card-image">
          <img src="<?php echo $photo; ?>" alt="<?php echo sanitize($p['name']); ?>">
          <div class="player-jersey">#<?php echo (int) $p['jersey_number']; ?></div>
        </div>
        <div class="player-card-content">
          <h3 class="player-name"><?php echo sanitize($p['name']); ?></h3>
          <div class="player-details">
            <div class="player-detail-item">
              <i class="fas fa-basketball-ball"></i>
              <span><?php echo sanitize($p['position']); ?></span>
            </div>
            <div class="player-detail-item">
              <i class="fas fa-shield-alt"></i>
              <span><?php echo sanitize($p['team_name']); ?></span>
            </div>
          </div>
        </div>
      </a>
    <?php endwhile; ?>
  </div>
  <div style="text-align:center;margin-top:30px;">
    <a href="players-division.php?division=Division%201&gender=<?php echo urlencode($activeGender); ?>"
      class="view-more-link">View All Division 1 Players</a>
  </div>
</section>

<!-- ===== Division 2 ===== -->
<section class="division-section">
  <h3 class="division-title">Division 2 Players</h3>
  <div class="grid col-3">
    <?php
    $sql2 = "
      SELECT p.id, p.name, p.position, p.jersey_number, p.photo, t.name AS team_name, t.gender, t.division
      FROM players p
      JOIN teams t ON t.id = p.team_id
      WHERE t.division='Division 2' $genderFilter
      ORDER BY p.name ASC
      LIMIT 9";
    $stmt2 = $mysqli->prepare($sql2);
    if ($genderFilter)
      $stmt2->bind_param('s', $activeGender);
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    while ($p = $res2->fetch_assoc()):
      $photo = !empty($p['photo']) ? '../../../admin/uploads/' . sanitize($p['photo']) : 'https://via.placeholder.com/600x300?text=Player';
      ?>
      <a class="player-card-pro" href="player-card.php?id=<?php echo (int) $p['id']; ?>">
        <div class="player-card-image">
          <img src="<?php echo $photo; ?>" alt="<?php echo sanitize($p['name']); ?>">
          <div class="player-jersey">#<?php echo (int) $p['jersey_number']; ?></div>
        </div>
        <div class="player-card-content">
          <h3 class="player-name"><?php echo sanitize($p['name']); ?></h3>
          <div class="player-details">
            <div class="player-detail-item">
              <i class="fas fa-basketball-ball"></i>
              <span><?php echo sanitize($p['position']); ?></span>
            </div>
            <div class="player-detail-item">
              <i class="fas fa-shield-alt"></i>
              <span><?php echo sanitize($p['team_name']); ?></span>
            </div>
          </div>
        </div>
      </a>
    <?php endwhile; ?>
  </div>
  <div style="text-align:center;margin-top:30px;">
    <a href="players-division.php?division=Division%202&gender=<?php echo urlencode($activeGender); ?>"
      class="view-more-link">View All Division 2 Players</a>
  </div>
</section>

<!-- ===== Leaderboards (tables side by side) ===== -->
<section id="leaderboards" style="margin-top:40px">
  <div class="section-title">
    <h2>Leaderboards</h2>
  </div>

  <div style="display:grid; grid-template-columns: repeat(3, 1fr); gap:16px;">
    <?php
    $stats = [
      'Points' => 'total_points',
      'Rebounds' => 'total_rebounds',
      'Assists' => 'total_assists',
      'Blocks' => 'total_blocks',
      'Steals' => 'total_steals'
    ];

    $i = 0;
    foreach ($stats as $label => $column):
      // For bottom row (Blocks, Steals), span 1 column each but leave the last column empty
      $style = '';
      if ($i === 3)
        $style = 'grid-column: 1 / 2;'; // Blocks starts at first column of second row
      if ($i === 4)
        $style = 'grid-column: 2 / 3;'; // Steals at second column of second row
    
      $sql = "
        SELECT p.name, t.name AS team_name,
               ROUND(s.$column / NULLIF(s.games_played,0),1) AS avg_stat
        FROM player_stats s
        JOIN players p ON p.id = s.player_id
        JOIN teams t ON t.id = p.team_id
        WHERE s.games_played > 0
        ORDER BY avg_stat DESC
        LIMIT 5";
      $res = $mysqli->query($sql);
      $i++;
      ?>
      <table style="border:1px solid #e5e7eb; border-radius:8px; width:100%; <?php echo $style; ?>">
        <thead style="background:#f3f4f6;">
          <tr>
            <th colspan="2" style="padding:8px; text-align:center;"><?php echo sanitize($label); ?></th>
          </tr>
        </thead>
        <tbody>
          <?php $rank = 1;
          while ($r = $res->fetch_assoc()): ?>
            <tr>
              <td style="padding:4px 8px;"><strong><?php echo $rank++; ?>.</strong> <?php echo sanitize($r['name']); ?></td>
              <td style="padding:4px 8px; text-align:right; font-weight:600;">
                <?php echo sanitize($r['avg_stat']); ?>
                <?php echo ($label === 'Points') ? 'PPG' : (($label === 'Rebounds') ? 'RPG' : (($label === 'Assists') ? 'APG' : (($label === 'Blocks') ? 'BPG' : 'SPG'))); ?>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endforeach; ?>
  </div>
</section>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>