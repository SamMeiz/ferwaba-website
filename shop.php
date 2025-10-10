<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="section-title">
  <h2>Shop</h2>
  <form method="get" class="grid col-2" style="gap:8px;max-width:520px">
    <select name="category">
      <option value="">All</option>
      <option value="Jerseys" <?php echo (($_GET['category'] ?? '')==='Jerseys')?'selected':''; ?>>Jerseys</option>
      <option value="Kits" <?php echo (($_GET['category'] ?? '')==='Kits')?'selected':''; ?>>Kits</option>
      <option value="Gear" <?php echo (($_GET['category'] ?? '')==='Gear')?'selected':''; ?>>Gear</option>
    </select>
    <button class="btn" type="submit">Filter</button>
  </form>
</section>

<div class="grid col-3">
<?php
$where=' WHERE is_active=1'; $types=''; $params=[];
if(!empty($_GET['category'])){ $where.=' AND category=?'; $types.='s'; $params[]=$_GET['category']; }
$stmt=$mysqli->prepare('SELECT id,name,price,image,category FROM shop_items' . $where . ' ORDER BY created_at DESC, id DESC');
if($types){ $stmt->bind_param($types, ...$params);} $stmt->execute(); $res=$stmt->get_result();
while($i=$res->fetch_assoc()): ?>
  <div class="card">
    <?php if($i['image']): ?><img src="/admin/uploads/<?php echo sanitize($i['image']); ?>" alt="img" style="width:100%;height:180px;object-fit:cover"><?php endif; ?>
    <div class="card-body">
      <h3><?php echo sanitize($i['name']); ?></h3>
      <div class="muted"><?php echo sanitize($i['category']); ?></div>
      <div style="margin-top:6px;font-weight:700">RWF <?php echo number_format((float)$i['price'],2); ?></div>
    </div>
  </div>
<?php endwhile; ?>
</div>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


