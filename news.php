<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="section-title">
  <h2>News</h2>
  <nav class="muted" style="display:flex;gap:12px;flex-wrap:wrap">
  <?php
$cats = ['Latest','Transfers','Injuries','Squad Updates'];
?>
  <?php foreach($cats as $cat): ?>
    <a class="btn" href="<?php echo asset_url('news.php?category=' . urlencode($cat)); ?>" style="background:#f3f4f6">
      <?php echo sanitize($cat); ?>
    </a>
  <?php endforeach; ?>
</nav>
</section>

<div class="grid col-3">
<?php
$where='';$types='';$params=[];
if(!empty($_GET['category'])){ $where=' WHERE category=?'; $types='s'; $params[]=$_GET['category']; }
$stmt=$mysqli->prepare('SELECT id,title,image,video_url,category,created_at FROM news' . $where . ' ORDER BY created_at DESC, id DESC');
if($where){ $stmt->bind_param($types, ...$params);} $stmt->execute(); $res=$stmt->get_result();
while($n=$res->fetch_assoc()): ?>
  <a class="card" href="/news.php?id=<?php echo (int)$n['id']; ?>">
    <?php if($n['image']): ?><img src="/admin/uploads/<?php echo sanitize($n['image']); ?>" alt="img" style="width:100%;height:160px;object-fit:cover"><?php endif; ?>
    <div class="card-body">
      <h3><?php echo sanitize($n['title']); ?></h3>
      <div class="muted"><?php echo sanitize($n['category'].' • '.$n['created_at']); ?></div>
    </div>
  </a>
<?php endwhile; ?>
</div>

<?php if(isset($_GET['id']) && ctype_digit($_GET['id'])): $id=(int)$_GET['id']; $q=$mysqli->query("SELECT * FROM news WHERE id=$id"); if($q && $art=$q->fetch_assoc()): ?>
<section style="margin-top:20px">
  <div class="card"><div class="card-body">
    <h2><?php echo sanitize($art['title']); ?></h2>
    <div class="muted" style="margin-bottom:8px"><?php echo sanitize($art['category'].' • '.$art['created_at']); ?></div>
    <?php if($art['image']): ?><img src="/admin/uploads/<?php echo sanitize($art['image']); ?>" alt="img" style="width:100%;max-height:360px;object-fit:cover;border-radius:8px;margin-bottom:12px"><?php endif; ?>
    <div><?php echo nl2br(sanitize($art['content'])); ?></div>
    <?php if($art['video_url']): ?><div style="margin-top:12px"><?php echo youtube_embed($art['video_url']); ?></div><?php endif; ?>
  </div></div>
</section>
<?php endif; endif; ?>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


