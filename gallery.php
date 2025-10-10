<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="section-title">
  <h2>Gallery</h2>
  <form method="get" class="grid col-2" style="gap:8px;max-width:520px">
    <select name="team_id">
      <option value="">All Teams</option>
      <?php $teams=$mysqli->query("SELECT id,name FROM teams ORDER BY name ASC"); while($t=$teams->fetch_assoc()): ?>
      <option value="<?php echo (int)$t['id']; ?>" <?php echo ((int)($_GET['team_id'] ?? 0)===(int)$t['id'])?'selected':''; ?>><?php echo sanitize($t['name']); ?></option>
      <?php endwhile; ?>
    </select>
    <button class="btn" type="submit">Filter</button>
  </form>
</section>

<div class="grid col-3">
<?php
$sql = "SELECT g.image,g.caption,t.name AS team_name FROM gallery g LEFT JOIN teams t ON t.id=g.team_id";
if (!empty($_GET['team_id']) && ctype_digit($_GET['team_id'])) {
  $tid = (int)$_GET['team_id'];
  $sql .= " WHERE g.team_id=$tid";
}
$sql .= " ORDER BY g.uploaded_at DESC";
$res = $mysqli->query($sql);
while($g=$res->fetch_assoc()): ?>
  <figure class="card">
    <img src="/admin/uploads/<?php echo sanitize($g['image']); ?>" alt="photo" style="width:100%;height:200px;object-fit:cover">
    <figcaption class="card-body">
      <strong><?php echo sanitize($g['team_name'] ?? ''); ?></strong>
      <div class="muted"><?php echo sanitize($g['caption']); ?></div>
    </figcaption>
  </figure>
<?php endwhile; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


