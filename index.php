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

<section>
  <div class="section-title">
    <h2>Latest News</h2>
    <a class="btn" href="/news.php">View All</a>
  </div>
  <div class="grid col-3" id="latestNews">
    <?php
    $res = $mysqli->query("SELECT id, caption AS title, image FROM gallery ORDER BY uploaded_at DESC LIMIT 3");
    if($res){
      while($row = $res->fetch_assoc()): ?>
        <article class="card">
          <img src="<?php echo '/admin/uploads/'.sanitize($row['image']); ?>" alt="news" style="width:100%;height:160px;object-fit:cover">
          <div class="card-body">
            <h3><?php echo sanitize($row['title'] ?: 'Team Update'); ?></h3>
            <a class="btn" href="/gallery.php">Open</a>
          </div>
        </article>
    <?php endwhile; } ?>
  </div>
</section>

<section>
  <div class="section-title">
    <h2>Upcoming Games</h2>
    <a class="btn" href="/games.php">All Games</a>
  </div>
  <div class="card">
    <table>
      <thead>
        <tr><th>Date</th><th>Match</th><th>Division</th><th>Gender</th><th>Location</th></tr>
      </thead>
      <tbody>
        <?php
        $q = "SELECT g.*, th.name AS home_name, ta.name AS away_name FROM games g
              JOIN teams th ON th.id = g.home_team_id
              JOIN teams ta ON ta.id = g.away_team_id
              WHERE g.status='Scheduled' ORDER BY g.game_date ASC LIMIT 5";
        if($r = $mysqli->query($q)){
          while($g = $r->fetch_assoc()): ?>
            <tr>
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

<section>
  <div class="section-title">
    <h2>Top Standings</h2>
    <a class="btn" href="/standings.php">Full Tables</a>
  </div>
  <div class="grid col-2">
    <?php
    $divisions = ["Division 1","Division 2"];
    foreach($divisions as $div){
      $stmt = $mysqli->prepare("SELECT s.*, t.name FROM standings s JOIN teams t ON t.id = s.team_id WHERE s.division=? ORDER BY s.points DESC, s.wins DESC LIMIT 5");
      $stmt->bind_param('s',$div);
      $stmt->execute();
      $res = $stmt->get_result();
      echo '<div class="card"><div class="card-body">';
      echo '<h3>'.sanitize($div).'</h3>';
      echo '<table><thead><tr><th>Team</th><th>GP</th><th>W</th><th>L</th><th>Pts</th></tr></thead><tbody>';
      while($row = $res->fetch_assoc()){
        echo '<tr>';
        echo '<td>'.sanitize($row['name']).'</td>';
        echo '<td>'.(int)$row['games_played'].'</td>';
        echo '<td>'.(int)$row['wins'].'</td>';
        echo '<td>'.(int)$row['losses'].'</td>';
        echo '<td>'.(int)$row['points'].'</td>';
        echo '</tr>';
      }
      echo '</tbody></table></div></div>';
    }
    ?>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


