<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="section-title">
  <h2>Players</h2>
  <form method="get" class="grid col-2" style="gap:8px;max-width:520px">
    <input type="text" name="q" placeholder="Search name" value="<?php echo sanitize($_GET['q'] ?? ''); ?>">
    <button class="btn" type="submit">Search</button>
  </form>
</section>

<div class="grid col-3">
<?php
$q = trim($_GET['q'] ?? '');
if ($q !== '') {
  $term = "%$q%";
  $stmt = $mysqli->prepare("SELECT p.id,p.name,p.position,p.jersey_number,p.photo,t.name AS team_name FROM players p LEFT JOIN teams t ON t.id=p.team_id WHERE p.name LIKE ? ORDER BY p.name ASC");
  $stmt->bind_param('s',$term);
} else {
  $stmt = $mysqli->prepare("SELECT p.id,p.name,p.position,p.jersey_number,p.photo,t.name AS team_name FROM players p LEFT JOIN teams t ON t.id=p.team_id ORDER BY p.name ASC");
}
$stmt->execute();
$res = $stmt->get_result();
while($p = $res->fetch_assoc()): ?>
  <div class="card">
    <img src="<?php echo $p['photo']? '/admin/uploads/'.sanitize($p['photo']):'https://via.placeholder.com/600x300?text=Player'; ?>" alt="photo" style="width:100%;height:200px;object-fit:cover">
    <div class="card-body">
      <h3><?php echo sanitize($p['name']); ?></h3>
      <div class="muted">#<?php echo (int)$p['jersey_number']; ?> • <?php echo sanitize($p['position']); ?> • <?php echo sanitize($p['team_name'] ?? ''); ?></div>
    </div>
  </div>
<?php endwhile; ?>
</div>

<section id="leaderboards" style="margin-top:20px">
  <div class="section-title"><h2>Leaderboards</h2></div>
  <div class="grid col-3">
    <div class="card"><div class="card-body"><h3>Points</h3><div class="muted">Coming soon</div></div></div>
    <div class="card"><div class="card-body"><h3>Rebounds</h3><div class="muted">Coming soon</div></div></div>
    <div class="card"><div class="card-body"><h3>Assists</h3><div class="muted">Coming soon</div></div></div>
  </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


