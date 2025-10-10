<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="section-title">
  <h2>BetPawa Playoffs</h2>
  <a class="btn" href="#history">Champion History</a>
  </section>

<?php
// Fetch by stage
$stages = ['Quarterfinal','Semifinal','Final','3rd Place'];
$byStage = [];
foreach($stages as $st){
  $stmt = $mysqli->prepare("SELECT p.*, th.name AS home_name, ta.name AS away_name FROM playoffs p LEFT JOIN teams th ON th.id=p.home_team_id LEFT JOIN teams ta ON ta.id=p.away_team_id WHERE p.stage=? ORDER BY p.start_date ASC, p.id ASC");
  $stmt->bind_param('s',$st);
  $stmt->execute();
  $byStage[$st] = $stmt->get_result();
}
?>

<div class="grid col-3">
  <div class="card"><div class="card-body">
    <h3>Quarterfinals</h3>
    <?php while($qf=$byStage['Quarterfinal']->fetch_assoc()): ?>
      <div style="border:1px solid #e5e7eb;border-radius:8px;padding:8px;margin-bottom:8px">
        <div class="muted"><?php echo sanitize($qf['start_date'].' - '.$qf['end_date']); ?></div>
        <strong><?php echo sanitize(($qf['home_name']??'TBD').' vs '.($qf['away_name']??'TBD')); ?></strong>
        <div><?php echo (int)$qf['home_score'].' - '.(int)$qf['away_score']; ?> (<?php echo sanitize($qf['status']); ?>)</div>
      </div>
    <?php endwhile; ?>
  </div></div>
  <div class="card"><div class="card-body">
    <h3>Semifinals</h3>
    <?php while($sf=$byStage['Semifinal']->fetch_assoc()): ?>
      <div style="border:1px solid #e5e7eb;border-radius:8px;padding:8px;margin-bottom:8px">
        <div class="muted"><?php echo sanitize($sf['start_date'].' - '.$sf['end_date']); ?></div>
        <strong><?php echo sanitize(($sf['home_name']??'TBD').' vs '.($sf['away_name']??'TBD')); ?></strong>
        <div><?php echo (int)$sf['home_score'].' - '.(int)$sf['away_score']; ?> (<?php echo sanitize($sf['status']); ?>)</div>
      </div>
    <?php endwhile; ?>
  </div></div>
  <div class="card"><div class="card-body">
    <h3>Final & 3rd Place</h3>
    <?php while($f=$byStage['Final']->fetch_assoc()): ?>
      <div style="border:1px solid #e5e7eb;border-radius:8px;padding:8px;margin-bottom:8px">
        <div class="muted"><?php echo sanitize($f['start_date'].' - '.$f['end_date']); ?></div>
        <strong><?php echo sanitize(($f['home_name']??'TBD').' vs '.($f['away_name']??'TBD')); ?></strong>
        <div><?php echo (int)$f['home_score'].' - '.(int)$f['away_score']; ?> (<?php echo sanitize($f['status']); ?>)</div>
      </div>
    <?php endwhile; ?>
    <?php while($tp=$byStage['3rd Place']->fetch_assoc()): ?>
      <div style="border:1px solid #e5e7eb;border-radius:8px;padding:8px;margin-bottom:8px">
        <div class="muted"><?php echo sanitize($tp['start_date'].' - '.$tp['end_date']); ?></div>
        <strong><?php echo sanitize(($tp['home_name']??'TBD').' vs '.($tp['away_name']??'TBD')); ?></strong>
        <div><?php echo (int)$tp['home_score'].' - '.(int)$tp['away_score']; ?> (<?php echo sanitize($tp['status']); ?>)</div>
      </div>
    <?php endwhile; ?>
  </div></div>
</div>

<section id="history" style="margin-top:20px">
  <div class="section-title"><h2>Champion History</h2></div>
  <div class="card"><div class="card-body">
    <div class="muted">Coming soon</div>
  </div></div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


