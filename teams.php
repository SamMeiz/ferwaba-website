<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="section-title">
  <h2>All Teams</h2>
  <form method="get" class="grid col-2" style="gap:8px;max-width:520px">
    <select name="gender">
      <option value="">All Genders</option>
      <option value="Men" <?php echo (($_GET['gender'] ?? '')==='Men')?'selected':''; ?>>Men</option>
      <option value="Women" <?php echo (($_GET['gender'] ?? '')==='Women')?'selected':''; ?>>Women</option>
    </select>
    <select name="division">
      <option value="">All Divisions</option>
      <option value="Division 1" <?php echo (($_GET['division'] ?? '')==='Division 1')?'selected':''; ?>>Division 1</option>
      <option value="Division 2" <?php echo (($_GET['division'] ?? '')==='Division 2')?'selected':''; ?>>Division 2</option>
    </select>
    <button class="btn" type="submit">Filter</button>
  </form>
</section>

<div class="grid col-3">
<?php
$where = [];$params=[];$types='';
if (!empty($_GET['gender'])) { $where[]='gender=?'; $params[]=$_GET['gender']; $types.='s'; }
if (!empty($_GET['division'])) { $where[]='division=?'; $params[]=$_GET['division']; $types.='s'; }
$sql = 'SELECT id,name,location,logo,gender,division FROM teams';
if ($where) { $sql .= ' WHERE '.implode(' AND ',$where); }
$sql .= ' ORDER BY name ASC';
$stmt = $mysqli->prepare($sql);
if ($where) { $stmt->bind_param($types, ...$params); }
$stmt->execute();
$res = $stmt->get_result();
while($t = $res->fetch_assoc()): ?>
  <a class="card" href="/team.php?id=<?php echo (int)$t['id']; ?>">
    <img src="<?php echo $t['logo']? '/admin/uploads/'.sanitize($t['logo']):'https://via.placeholder.com/600x300?text=Team'; ?>" alt="logo" style="width:100%;height:160px;object-fit:cover">
    <div class="card-body">
      <h3><?php echo sanitize($t['name']); ?></h3>
      <div class="muted"><?php echo sanitize($t['gender'].' • '.$t['division'].' • '.$t['location']); ?></div>
    </div>
  </a>
<?php endwhile; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


