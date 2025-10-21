<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="hero">
  <h1>Rwanda Basketball League(RBL)</h1>
  <p>Official Rwanda Basketball League hub. Fixtures, results, standings, news and more.</p>
  <h3>Redefining African basketball with the fire, rhythm, and spirit of a continent.</h2>
  <div style="margin-top:14px">
    <a class="btn" href="/games.php">View Schedule</a>
    <a class="btn" href="/standings.php" style="margin-left:8px">Standings</a>
  </div>
  <p class="muted" style="margin-top:8px">Timezone: Africa/Kigali</p>
</section>
<!-- Latest News -->
<section>
  <div class="section-title">
    <h2>Latest News</h2>
    <a class="btn" href="/news.php">View All</a>
  </div>
  <div class="grid col-3" id="latestNews">
    <?php
    // Fetch latest 3 news articles
    $res = $mysqli->query("SELECT id, title, image FROM news ORDER BY created_at DESC LIMIT 3");
    if ($res) {
      while ($row = $res->fetch_assoc()): ?>
        <article class="card">
          <?php if ($row['image']): ?>
            <img src="<?php echo '/ferwaba1/admin/uploads/'.sanitize($row['image']); ?>" 
                 alt="<?php echo sanitize($row['title']); ?>" 
                 style="width:100%;height:160px;object-fit:cover">
          <?php endif; ?>
          <div class="card-body">
            <h3><?php echo sanitize($row['title']); ?></h3>
            <a class="btn" href="news.php?id=<?php echo (int)$row['id']; ?>">Read More</a>
          </div>
        </article>
    <?php endwhile; } ?>
  </div>
</section>

<!-- Upcoming Games -->
<section>
  <div class="section-title">
    <h2>Upcoming Games</h2>
    <a class="btn" href="/games.php">All Games</a>
  </div>
  <div class="card">
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Match</th>
          <th>Division</th>
          <th>Gender</th>
          <th>Location</th>
        </tr>
      </thead>
      <tbody>
        <?php
        $today = date('Y-m-d');
        $three_days = date('Y-m-d', strtotime('+3 days'));

        $q = "SELECT g.*, th.name AS home_name, ta.name AS away_name 
              FROM games g
              JOIN teams th ON th.id = g.home_team_id
              JOIN teams ta ON ta.id = g.away_team_id
              WHERE g.status='Scheduled' 
              ORDER BY g.game_date ASC, g.id ASC 
              LIMIT 5";

        if($r = $mysqli->query($q)){
          while($g = $r->fetch_assoc()):
            $row_class = '';
            if ($g['game_date'] >= $today && $g['game_date'] <= $three_days) {
                $row_class = 'upcoming-highlight'; // add CSS class for highlight
            }
        ?>
            <tr class="<?php echo $row_class; ?>">
              <td><?php echo sanitize($g['game_date']); ?></td>
              <td><?php echo sanitize($g['home_name'].' vs '.$g['away_name']); ?></td>
              <td><?php echo sanitize($g['division']); ?></td>
              <td><?php echo sanitize($g['gender']); ?></td>
              <td><?php echo sanitize($g['location']); ?></td>
            </tr>
        <?php endwhile; } ?>
      </tbody>
    </table>
  </div>
</section>

<style>
  .upcoming-highlight {
    background-color: rgba(34,197,94,0.15); /* light green highlight */
    font-weight: 600;
  }
</style>

<!-- Top Standings -->
<section>
  <div class="section-title">
    <h2>🏀 Top Standings</h2>
  </div>

  <div class="grid col-2" style="gap:16px;"> <!-- 2-column grid -->
    <?php
    $divisions = ["Division 1", "Division 2"];
    foreach ($divisions as $div):
      // Determine selected gender for this division (default Men)
      $paramName = 'gender_' . str_replace(' ', '_', $div);
      $selectedGender = $_GET[$paramName] ?? 'Men';
      $genders = ["Men", "Women"];

      // Fetch top 5 teams for this division and selected gender
      $stmt = $mysqli->prepare("
        SELECT s.*, t.name 
        FROM standings s 
        JOIN teams t ON t.id = s.team_id 
        WHERE s.division=? AND s.gender=? 
        ORDER BY s.points DESC, s.wins DESC 
        LIMIT 5
      ");
      $stmt->bind_param('ss', $div, $selectedGender);
      $stmt->execute();
      $res = $stmt->get_result();
    ?>

    <div class="card">
      <div class="card-body">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;">
          <h4><?php echo sanitize($div); ?></h4>
          <a href="standings.php?division=<?php echo urlencode($div); ?>&gender=<?php echo urlencode($selectedGender); ?>" class="btn-small">Full Table</a>
        </div>

        <!-- Gender buttons for this division -->
        <div style="margin-bottom:12px;">
          <?php foreach ($genders as $gender): 
            $activeClass = ($selectedGender === $gender) ? 'btn' : 'btn-small';
            $url = "?{$paramName}=" . urlencode($gender);
          ?>
            <a href="<?php echo $url; ?>" class="<?php echo $activeClass; ?>" style="margin-right:8px;">
              <?php echo sanitize($gender); ?>
            </a>
          <?php endforeach; ?>
        </div>

        <table>
          <thead>
            <tr><th>Team</th><th>GP</th><th>W</th><th>L</th><th>Pts</th></tr>
          </thead>
          <tbody>
            <?php if ($res->num_rows > 0): while($row = $res->fetch_assoc()): ?>
            <tr>
              <td><?php echo sanitize($row['name']); ?></td>
              <td><?php echo (int)$row['games_played']; ?></td>
              <td><?php echo (int)$row['wins']; ?></td>
              <td><?php echo (int)$row['losses']; ?></td>
              <td><?php echo (int)$row['points']; ?></td>
            </tr>
            <?php endwhile; else: ?>
            <tr><td colspan="5" style="text-align:center;color:#999;">No data available</td></tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>

    <?php endforeach; ?>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


