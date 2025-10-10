<?php require_once __DIR__ . '/includes/header.php'; ?>

<?php
$teamParam = $_GET['team'] ?? 'Senior Men';
$title = in_array($teamParam, ['Senior Men','Senior Women','U18 Men','U18 Women','U16 Men','U16 Women']) ? $teamParam : 'Senior Men';
?>

<section class="section-title">
  <h2>National Team - <?php echo sanitize($title); ?></h2>
  <nav class="muted" style="display:flex;gap:10px;flex-wrap:wrap">
    <?php $opts=['Senior Men','Senior Women','U18 Men','U18 Women','U16 Men','U16 Women']; foreach($opts as $o): ?>
      <a class="btn" href="<?php echo asset_url('national-team.php?team='.urlencode($o)); ?>" style="background:#f3f4f6"><?php echo $o; ?></a>
    <?php endforeach; ?>
  </nav>
</section>

<div class="grid col-2">
  <div class="card"><div class="card-body">
    <h3>Roster</h3>
    <div class="muted">Coming soon</div>
  </div></div>
  <div class="card"><div class="card-body">
    <h3>Coaches</h3>
    <div class="muted">Coming soon</div>
  </div></div>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


