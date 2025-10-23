<?php 
require_once __DIR__ . '/includes/header.php'; 
?>

<section class="section-title">
  <h2>Players</h2>

  <!-- Gender filter buttons -->
  <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:8px;">
    <?php
    $genders = ['All','Men','Women'];
    $activeGender = $_GET['gender'] ?? 'All';
    foreach($genders as $g):
      $isActive = ($activeGender === $g) ? 'background:#2563eb;color:#fff;' : 'background:#f3f4f6;';
    ?>
      <a href="?gender=<?php echo urlencode($g); ?>" class="btn" style="<?php echo $isActive; ?>">
        <?php echo $g; ?>
      </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- ===== Division 1 ===== -->
<section>
  <h3 style="margin-top:20px">Division 1 Players</h3>
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
    if($genderFilter) $stmt->bind_param('s', $activeGender);
    $stmt->execute();
    $res = $stmt->get_result();
    while($p = $res->fetch_assoc()):
      $photo = !empty($p['photo']) ? 'admin/uploads/'.sanitize($p['photo']) : 'https://via.placeholder.com/600x300?text=Player';
    ?>
      <a class="card" href="player-card.php?id=<?php echo (int)$p['id']; ?>">
        <img src="<?php echo $photo; ?>" alt="<?php echo sanitize($p['name']); ?>" style="width:100%;height:220px;object-fit:cover">
        <div class="card-body">
          <h3><?php echo sanitize($p['name']); ?></h3>
          <div class="muted">#<?php echo (int)$p['jersey_number']; ?> • <?php echo sanitize($p['position']); ?> • <?php echo sanitize($p['team_name']); ?></div>
        </div>
      </a>
    <?php endwhile; ?>
  </div>
  <div style="text-align:center;margin-top:10px;">
    <a href="players-division.php?division=Division%201&gender=<?php echo urlencode($activeGender); ?>" class="btn">View More</a>
  </div>
</section>

<!-- ===== Division 2 ===== -->
<section>
  <h3 style="margin-top:20px">Division 2 Players</h3>
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
    if($genderFilter) $stmt2->bind_param('s', $activeGender);
    $stmt2->execute();
    $res2 = $stmt2->get_result();
    while($p = $res2->fetch_assoc()):
      $photo = !empty($p['photo']) ? 'admin/uploads/'.sanitize($p['photo']) : 'https://via.placeholder.com/600x300?text=Player';
    ?>
      <a class="card" href="player-card.php?id=<?php echo (int)$p['id']; ?>">
        <img src="<?php echo $photo; ?>" alt="<?php echo sanitize($p['name']); ?>" style="width:100%;height:220px;object-fit:cover">
        <div class="card-body">
          <h3><?php echo sanitize($p['name']); ?></h3>
          <div class="muted">#<?php echo (int)$p['jersey_number']; ?> • <?php echo sanitize($p['position']); ?> • <?php echo sanitize($p['team_name']); ?></div>
        </div>
      </a>
    <?php endwhile; ?>
  </div>
  <div style="text-align:center;margin-top:10px;">
    <a href="players-division.php?division=Division%202&gender=<?php echo urlencode($activeGender); ?>" class="btn">View More</a>
  </div>
</section>

<!-- ===== Leaderboards (tables side by side) ===== -->
<section id="leaderboards" style="margin-top:40px">
  <div class="section-title"><h2>Leaderboards</h2></div>

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
    foreach($stats as $label => $column):
      // For bottom row (Blocks, Steals), span 1 column each but leave the last column empty
      $style = '';
      if($i === 3) $style = 'grid-column: 1 / 2;'; // Blocks starts at first column of second row
      if($i === 4) $style = 'grid-column: 2 / 3;'; // Steals at second column of second row

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
          <tr><th colspan="2" style="padding:8px; text-align:center;"><?php echo sanitize($label); ?></th></tr>
        </thead>
        <tbody>
          <?php $rank=1; while($r=$res->fetch_assoc()): ?>
          <tr>
            <td style="padding:4px 8px;"><strong><?php echo $rank++; ?>.</strong> <?php echo sanitize($r['name']); ?></td>
            <td style="padding:4px 8px; text-align:right; font-weight:600;">
              <?php echo sanitize($r['avg_stat']); ?>
              <?php echo ($label === 'Points')?'PPG':(($label === 'Rebounds')?'RPG':(($label === 'Assists')?'APG':(($label === 'Blocks')?'BPG':'SPG'))); ?>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php endforeach; ?>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
