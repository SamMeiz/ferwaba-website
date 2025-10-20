<?php 
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/config.php';

if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) { 
  redirect('teams.php'); 
}

$team_id = (int)$_GET['id'];

// Fetch team details
$stmt = $mysqli->prepare("SELECT * FROM teams WHERE id=? LIMIT 1");
$stmt->bind_param('i', $team_id);
$stmt->execute();
$team = $stmt->get_result()->fetch_assoc();

if (!$team) { redirect('teams.php'); }

// Roster
$players = $mysqli->query("
  SELECT id, name, position, jersey_number, height, nationality, photo 
  FROM players 
  WHERE team_id = $team_id 
  ORDER BY jersey_number ASC
");

// Coaches
$coaches = $mysqli->query("
  SELECT id, name, role, nationality, photo 
  FROM coaches 
  WHERE team_id = $team_id 
  ORDER BY FIELD(role, 'Head Coach', 'Assistant Coach', 'Team Staff'), name ASC
");

// Gallery
$gallery = $mysqli->query("
  SELECT image, caption 
  FROM gallery 
  WHERE team_id = $team_id 
  ORDER BY uploaded_at DESC LIMIT 12
");

// Player stats (auto calculated)
$stats = $mysqli->query("
  SELECT ps.*, p.name 
  FROM player_stats ps
  JOIN players p ON ps.player_id = p.id
  WHERE p.team_id = $team_id
  ORDER BY p.name ASC
");

// Fixtures & Results
$games = $mysqli->query("
  SELECT g.*, th.name AS home_name, ta.name AS away_name
  FROM games g
  JOIN teams th ON th.id = g.home_team_id
  JOIN teams ta ON ta.id = g.away_team_id
  WHERE g.home_team_id = $team_id OR g.away_team_id = $team_id
  ORDER BY g.game_date DESC LIMIT 10
");
?>

<!-- TEAM HEADER -->
<section class="section-title" style="text-align:center;">
  <?php if (!empty($team['logo'])): ?>
    <img src="admin/uploads/<?php echo sanitize($team['logo']); ?>" 
         alt="<?php echo sanitize($team['name']); ?> Logo" 
         style="width:160px;height:160px;object-fit:cover;border-radius:50%;margin-bottom:10px;">
  <?php endif; ?>

  <h2><?php echo sanitize($team['name']); ?></h2>
  <div class="muted">
    <?php echo sanitize($team['gender'].' • '.$team['division'].' • '.$team['location']); ?>
  </div>
</section>

<!-- ROSTER AND COACHES -->
<div class="grid col-2" style="margin-top:20px;">
  <div class="card">
    <div class="card-body">
      <h3>Roster</h3>
      <table>
        <thead>
          <tr>
            <th>Photo</th>
            <th>#</th>
            <th>Name</th>
            <th>Position</th>
            <th>Height</th>
            <th>Nationality</th>
          </tr>
        </thead>
        <tbody>
          <?php while($p = $players->fetch_assoc()): 
            $photo = !empty($p['photo']) ? 'admin/uploads/'.sanitize($p['photo']) : 'https://via.placeholder.com/80x80?text=Player';
          ?>
          <tr>
            <td><img src="<?php echo $photo; ?>" alt="Player Photo" style="width:60px;height:60px;object-fit:cover;border-radius:50%;"></td>
            <td><?php echo (int)$p['jersey_number']; ?></td>
            <td><?php echo sanitize($p['name']); ?></td>
            <td><?php echo sanitize($p['position']); ?></td>
            <td><?php echo sanitize($p['height']); ?></td>
            <td><?php echo sanitize($p['nationality']); ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <div class="card">
    <div class="card-body">
      <h3>Coaches</h3>
      <table>
        <thead>
          <tr>
            <th>Photo</th>
            <th>Name</th>
            <th>Role</th>
            <th>Nationality</th>
          </tr>
        </thead>
        <tbody>
          <?php while($c = $coaches->fetch_assoc()): 
            $cphoto = !empty($c['photo']) ? 'admin/uploads/'.sanitize($c['photo']) : 'https://via.placeholder.com/80x80?text=Coach';
          ?>
          <tr>
            <td><img src="<?php echo $cphoto; ?>" alt="Coach Photo" style="width:60px;height:60px;object-fit:cover;border-radius:50%;"></td>
            <td><?php echo sanitize($c['name']); ?></td>
            <td><?php echo sanitize($c['role']); ?></td>
            <td><?php echo sanitize($c['nationality']); ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<br>

 <!-- PLAYER STATS -->
<div class="card">
  <div class="card-body">
    <h3>Player Statistics</h3>
    <table>
      <thead>
        <tr>
          <th>Player</th>
          <th>PPG</th>
          <th>RPG</th>
          <th>APG</th>
          <th>SPG</th>
          <th>BPG</th>
          <th>FG%</th>
          <th>3P%</th>
          <th>FT%</th>
        </tr>
      </thead>
      <tbody>
        <?php while($s = $stats->fetch_assoc()): 
          $gp = max(1, $s['games_played']); // avoid divide by zero
          $ppg = round($s['total_points'] / $gp, 1);
          $rpg = round($s['total_rebounds'] / $gp, 1);
          $apg = round($s['total_assists'] / $gp, 1);
          $spg = round($s['total_steals'] / $gp, 1);
          $bpg = round($s['total_blocks'] / $gp, 1);
          $fgp = $s['fg_attempted'] > 0 ? round(($s['fg_made'] / $s['fg_attempted']) * 100, 1) : 0;
          $tp = $s['three_attempted'] > 0 ? round(($s['three_made'] / $s['three_attempted']) * 100, 1) : 0;
          $ftp = $s['ft_attempted'] > 0 ? round(($s['ft_made'] / $s['ft_attempted']) * 100, 1) : 0;
        ?>
        <tr>
          <!-- Player name links to their profile page -->
          <td>
            <a href="player.php?id=<?php echo (int)$s['player_id']; ?>">
              <?php echo sanitize($s['name']); ?>
            </a>
          </td>
          <td><?php echo $ppg; ?></td>
          <td><?php echo $rpg; ?></td>
          <td><?php echo $apg; ?></td>
          <td><?php echo $spg; ?></td>
          <td><?php echo $bpg; ?></td>
          <td><?php echo $fgp; ?>%</td>
          <td><?php echo $tp; ?>%</td>
          <td><?php echo $ftp; ?>%</td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>

<!-- FIXTURES & RESULTS -->
<section style="margin-top:32px;">
  <div class="section-title"><h3>Fixtures & Results</h3></div>
  <div class="card">
    <table>
      <thead>
        <tr>
          <th>Date</th>
          <th>Match</th>
          <th>Status</th>
          <th>Score</th>
        </tr>
      </thead>
      <tbody>
        <?php while($gm = $games->fetch_assoc()): ?>
        <tr>
          <td><?php echo sanitize($gm['game_date']); ?></td>
          <td><?php echo sanitize($gm['home_name'].' vs '.$gm['away_name']); ?></td>
          <td><?php echo sanitize($gm['status']); ?></td>
          <td><?php echo (int)$gm['home_score'].' - '.(int)$gm['away_score']; ?></td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</section>
<!-- GALLERY -->
<section>
    <div class="section-title"><h3>Gallery</h3></div>
    <div class="grid col-3">
      <?php while($g = $gallery->fetch_assoc()): 
        $img = 'admin/uploads/'.sanitize($g['image']);
      ?>
      <figure class="card" style="cursor:pointer;" onclick="openLightbox('<?php echo $img; ?>')">
        <img src="<?php echo $img; ?>" alt="Gallery Photo" style="width:100%;height:160px;object-fit:cover;border-bottom:1px solid #ddd;">
        <figcaption class="card-body muted"><?php echo sanitize($g['caption']); ?></figcaption>
      </figure>
      <?php endwhile; ?>
    </div>
  </section>
</div>

<!-- LIGHTBOX JS -->
<div id="lightbox" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.8);justify-content:center;align-items:center;">
  <img id="lightbox-img" src="" style="max-width:90%;max-height:90%;border:5px solid #fff;border-radius:10px;">
</div>

<script>
function openLightbox(src){
  document.getElementById('lightbox-img').src = src;
  document.getElementById('lightbox').style.display='flex';
}
document.getElementById('lightbox').onclick = () => {
  document.getElementById('lightbox').style.display='none';
};
</script>


<?php require_once __DIR__ . '/includes/footer.php'; ?>
