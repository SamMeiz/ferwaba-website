<?php require_once __DIR__ . '/includes/header.php'; ?>
 <head>
  <style>
 .btn-ticket {
  display: inline-block;
  background: #0047AB;
  color: #fff;
  font-size: 13px;
  font-weight: 600;
  padding: 6px 12px;
  border-radius: 4px;
  text-decoration: none;
  border: 1px solid #0047AB;
  transition: 0.25s;
}


</style>
 </head>
<section class="hero">
  <div class="hero-backgrounds">
    <div class="hero-bg active" style="background-image:url('img/banner1.png');" data-title="Rwanda Basketball League" data-sub="Official RBL hub. Fixtures, results, standings, news."></div>
    <div class="hero-bg" style="background-image:url('img/banner2.png');" data-title="Redefining African Basketball" data-sub="Experience the fire, rhythm, and spirit of a continent."></div>
    <div class="hero-bg" style="background-image:url('img/banner3.png');" data-title="Exciting Matchups" data-sub="Stay updated with live scores, schedules, and results."></div>
    <div class="hero-bg" style="background-image:url('img/banner4.png');" data-title="Future of Rwandan Basketball" data-sub="New talents. New era. Same passion."></div>
    <div class="hero-bg" style="background-image:url('img/banner5.png');" data-title="Women's League Rising" data-sub="Empowering women through basketball."></div>
    <div class="hero-bg" style="background-image:url('img/banner6.png');" data-title="National Teams" data-sub="Proudly representing Rwanda."></div>
    <div class="hero-bg" style="background-image:url('img/banner7.png');" data-title="FERWABA Development" data-sub="Building the next generation of players."></div>
    <div class="hero-bg" style="background-image:url('img/banner8.png');" data-title="Spirit of the Game" data-sub="Unity, Passion, and Excellence."></div>
  </div>

  <div class="hero-overlay"></div>

  <div class="hero-content active">
    <h1>Rwanda Basketball League</h1>
    <p>Official RBL hub. Fixtures, results, standings, news.</p>
    <h3>Redefining African basketball with the fire, rhythm, and spirit of a continent.</h3>
    <div style="margin-top:14px">
      <a class="btn" href="games.php">View Schedule</a>
      <a class="btn" href="standings.php" style="margin-left:8px">Standings</a>
    </div>
  </div>
</section> <br><br><br>



<!-- Latest News -->
<div class="news-slider-wrapper">
  <div class="news-slider">
    <?php
    $res = $mysqli->query("SELECT id,title,image,content FROM news ORDER BY created_at DESC LIMIT 10");
    if($res): while($row = $res->fetch_assoc()):
    ?>
      <div class="news-slide">
        <?php if(!empty($row['image'])): ?>
          <img src="<?php echo '/ferwaba1/admin/uploads/'.sanitize($row['image']); ?>" alt="<?php echo sanitize($row['title']); ?>">
        <?php else: ?>
          <div style="background:#ddd;width:100%;height:500px;"></div>
        <?php endif; ?>
        <div class="caption">
          <h3><?php echo sanitize($row['title']); ?></h3>
          <p><?php echo substr(strip_tags($row['content']),0,100).'...'; ?></p>
          <a class="btn" href="news.php?id=<?php echo (int)$row['id']; ?>">Read More</a>
        </div>
      </div>
    <?php endwhile; endif; ?>
  </div>
</div>
</section>


<!-- Upcoming Games -->
<section>
  <div class="section-title">
    <h2>Upcoming Games</h2>
    <a class="btn" href="/games.php">All Games</a>
  </div>
  <div class="card">
    <div class="table-wrapper">
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Match</th>
          <th>Division</th>
          <th>Gender</th>
          <th>Location</th>
          <th>Ticket</th>
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
        <td>
          <a href="https://ticqet.rw" target="_blank" class="btn-ticket">Get Ticket</a>
        </td>
      </tr>
  <?php endwhile; } ?>
</tbody>

    </table>
  
  </div></div>
</section>

<!-- Top Standings -->
<section>
  <div class="section-title">
    <h2>🏀 Top Standings</h2>
  </div>

  <div class="grid col-1">
    <?php
    $divisions = ["Division 1", "Division 2"];
    foreach ($divisions as $div):
      $paramName = 'gender_' . str_replace(' ', '_', $div);
      $selectedGender = $_GET[$paramName] ?? 'Men';
      $genders = ["Men", "Women"];

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
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:12px;flex-wrap:wrap;gap:8px;">
          <h4 style="margin:0;"><?php echo sanitize($div); ?></h4>
          <a href="standings.php?division=<?php echo urlencode($div); ?>&gender=<?php echo urlencode($selectedGender); ?>" class="btn-small">Full Table</a>
        </div>

        <!-- Gender buttons -->
        <div style="margin-bottom:16px;display:flex;gap:8px;flex-wrap:wrap;">
          <?php foreach ($genders as $gender): 
            $isActive = ($selectedGender === $gender);
            $activeClass = $isActive ? 'btn-small active' : 'btn-small';
            $url = "?{$paramName}=" . urlencode($gender);
          ?>
            <a href="<?php echo $url; ?>" class="<?php echo $activeClass; ?>" style="min-width:60px;text-align:center;">
              <?php echo sanitize($gender); ?>
            </a>
          <?php endforeach; ?>
        </div>

        <div class="table-wrapper">
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
    </div>

    <?php endforeach; ?>
  </div>
</section>


<script>
// Hero Slideshow
const heroBGs = document.querySelectorAll('.hero-bg');
let current = 0;

function showSlide(index){
  heroBGs.forEach((bg,i)=>bg.classList.remove('active'));
  const bg = heroBGs[index];
  const title = bg.getAttribute('data-title');
  const sub = bg.getAttribute('data-sub');
  const heroContent = document.querySelector('.hero-content');
  heroContent.querySelector('h1').textContent = title;
  heroContent.querySelector('p').textContent = sub;
  heroBGs[index].classList.add('active');
  heroContent.classList.add('active');
}

setInterval(()=>{
  current = (current+1)%heroBGs.length;
  showSlide(current);
},5000);
</script>


<?php require_once __DIR__ . '/includes/footer.php'; ?>


