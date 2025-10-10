<?php require_once __DIR__ . '/includes/header.php';
if (!isset($_GET['id']) || !ctype_digit($_GET['id'])) { redirect('/teams.php'); }
$team_id = (int)$_GET['id'];

$stmt = $mysqli->prepare("SELECT * FROM teams WHERE id=? LIMIT 1");
$stmt->bind_param('i',$team_id);
$stmt->execute();
$team = $stmt->get_result()->fetch_assoc();
if (!$team) { redirect('/teams.php'); }

// Roster
$players = $mysqli->query("SELECT id,name,position,jersey_number,photo FROM players WHERE team_id=".$team_id." ORDER BY jersey_number ASC");
// Coaches
$coaches = $mysqli->query("SELECT id,name,role,nationality,photo FROM coaches WHERE team_id=".$team_id." ORDER BY FIELD(role,'Head Coach','Assistant Coach','Team Staff'), name ASC");
// Gallery
$gallery = $mysqli->query("SELECT image,caption FROM gallery WHERE team_id=".$team_id." ORDER BY uploaded_at DESC LIMIT 12");
// Fixtures/Results
$games = $mysqli->query("SELECT g.*, th.name AS home_name, ta.name AS away_name
  FROM games g
  JOIN teams th ON th.id=g.home_team_id
  JOIN teams ta ON ta.id=g.away_team_id
  WHERE g.home_team_id=$team_id OR g.away_team_id=$team_id
  ORDER BY g.game_date DESC LIMIT 10");
?>

<section class="section-title">
  <h2><?php echo sanitize($team['name']); ?></h2>
  <div class="muted"><?php echo sanitize($team['gender'].' • '.$team['division'].' • '.$team['location']); ?></div>
</section>

<div class="grid col-2">
  <div class="card">
    <div class="card-body">
      <h3>Roster</h3>
      <table>
        <thead><tr><th>#</th><th>Name</th><th>Position</th></tr></thead>
        <tbody>
          <?php while($p = $players->fetch_assoc()): ?>
          <tr>
            <td><?php echo (int)$p['jersey_number']; ?></td>
            <td><?php echo sanitize($p['name']); ?></td>
            <td><?php echo sanitize($p['position']); ?></td>
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
        <thead><tr><th>Name</th><th>Role</th><th>Nationality</th></tr></thead>
        <tbody>
          <?php while($c = $coaches->fetch_assoc()): ?>
          <tr>
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

<section style="margin-top:16px">
  <div class="section-title"><h3>Gallery</h3></div>
  <div class="grid col-3">
    <?php while($g = $gallery->fetch_assoc()): ?>
    <figure class="card">
      <img src="<?php echo '/admin/uploads/'.sanitize($g['image']); ?>" alt="photo" style="width:100%;height:140px;object-fit:cover">
      <figcaption class="card-body muted"><?php echo sanitize($g['caption']); ?></figcaption>
    </figure>
    <?php endwhile; ?>
  </div>
</section>

<section style="margin-top:16px">
  <div class="section-title"><h3>Fixtures & Results</h3></div>
  <div class="card">
    <table>
      <thead><tr><th>Date</th><th>Match</th><th>Status</th><th>Score</th></tr></thead>
      <tbody>
        <?php while($gm = $games->fetch_assoc()): $isHome = (int)$gm['home_team_id']===$team_id; ?>
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

<?php require_once __DIR__ . '/includes/footer.php'; ?>


