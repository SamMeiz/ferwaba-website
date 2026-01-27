<?php require_once __DIR__ . '/../includes/header.php'; ?>

<style>
/* Professional Gallery Page */
.page-header {
  background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
  padding: 60px 40px;
  margin: -20px -16px 40px -16px;
  border-radius: 0 0 24px 24px;
  text-align: center;
}
.page-header h1 {
  font-size: 42px;
  font-weight: 800;
  color: #fff;
  margin: 0 0 8px 0;
}
.page-header p {
  color: rgba(255,255,255,0.8);
  font-size: 16px;
  margin: 0;
}

.gallery-filters {
  background: #fff;
  padding: 24px;
  border-radius: 16px;
  box-shadow: 0 4px 20px rgba(0,0,0,0.08);
  margin-bottom: 32px;
  display: flex;
  justify-content: center;
  align-items: center;
  gap: 16px;
  flex-wrap: wrap;
}

.gallery-filters select {
  padding: 14px 24px;
  border: 2px solid #e5e7eb;
  border-radius: 12px;
  background: #fff;
  font-size: 15px;
  font-weight: 600;
  color: #1a365d;
  min-width: 200px;
  cursor: pointer;
  transition: all 0.2s ease;
}

.gallery-filters select:hover {
  border-color: #1a365d;
}

.gallery-filters select:focus {
  outline: none;
  border-color: #fbbf24;
  box-shadow: 0 0 0 3px rgba(251,191,36,0.2);
}

.filter-btn {
  background: linear-gradient(135deg, #1a365d 0%, #2c5282 100%);
  color: #fff;
  border: none;
  padding: 14px 32px;
  border-radius: 12px;
  font-weight: 700;
  font-size: 15px;
  cursor: pointer;
  transition: all 0.3s ease;
}

.filter-btn:hover {
  transform: translateY(-2px);
  box-shadow: 0 8px 24px rgba(26,54,93,0.3);
}

.gallery-grid {
  display: grid;
  grid-template-columns: repeat(3, 1fr);
  gap: 24px;
}

.gallery-item {
  position: relative;
  border-radius: 16px;
  overflow: hidden;
  background: #fff;
  box-shadow: 0 8px 24px rgba(0,0,0,0.08);
  transition: all 0.4s cubic-bezier(0.165, 0.84, 0.44, 1);
}

.gallery-item:hover {
  transform: translateY(-8px);
  box-shadow: 0 16px 40px rgba(0,0,0,0.15);
}

.gallery-item img {
  width: 100%;
  height: 260px;
  object-fit: cover;
  display: block;
  transition: transform 0.5s ease;
}

.gallery-item:hover img {
  transform: scale(1.08);
}

.gallery-overlay {
  position: absolute;
  inset: 0;
  background: linear-gradient(to top, rgba(26,54,93,0.95) 0%, rgba(26,54,93,0.4) 50%, transparent 100%);
  display: flex;
  flex-direction: column;
  justify-content: flex-end;
  padding: 24px;
  opacity: 0;
  transition: opacity 0.4s ease;
}

.gallery-item:hover .gallery-overlay {
  opacity: 1;
}

.gallery-team {
  font-size: 18px;
  font-weight: 700;
  color: #fff;
  margin-bottom: 6px;
}

.gallery-caption {
  font-size: 14px;
  color: rgba(255,255,255,0.8);
  line-height: 1.5;
}

.gallery-caption-always {
  padding: 20px;
  background: #fff;
}

.gallery-caption-always strong {
  font-size: 16px;
  color: #1a365d;
  display: block;
  margin-bottom: 4px;
}

.gallery-caption-always p {
  font-size: 14px;
  color: #64748b;
  margin: 0;
}

.empty-state {
  text-align: center;
  padding: 80px 40px;
  background: #fff;
  border-radius: 16px;
  box-shadow: 0 4px 16px rgba(0,0,0,0.06);
  grid-column: 1 / -1;
}

.empty-state i {
  font-size: 64px;
  color: #e5e7eb;
  margin-bottom: 20px;
}

.empty-state h3 {
  font-size: 24px;
  color: #1a365d;
  margin-bottom: 8px;
}

.empty-state p {
  color: #64748b;
  font-size: 16px;
}

@media (max-width: 1024px) {
  .gallery-grid {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 640px) {
  .gallery-grid {
    grid-template-columns: 1fr;
  }
  .page-header {
    padding: 40px 20px;
    margin: -20px -16px 30px -16px;
  }
  .page-header h1 {
    font-size: 28px;
  }
}
</style>

<div class="page-header">
  <h1><i class="fas fa-images"></i> Photo Gallery</h1>
  <p>Capturing the best moments from Rwanda Basketball League</p>
</div>

<form method="get" class="gallery-filters">
  <select name="team_id">
    <option value="">All Teams</option>
    <?php $teams=$mysqli->query("SELECT id,name FROM teams ORDER BY name ASC"); while($t=$teams->fetch_assoc()): ?>
    <option value="<?php echo (int)$t['id']; ?>" <?php echo ((int)($_GET['team_id'] ?? 0)===(int)$t['id'])?'selected':''; ?>><?php echo sanitize($t['name']); ?></option>
    <?php endwhile; ?>
  </select>
  <button class="filter-btn" type="submit"><i class="fas fa-filter"></i> Filter Photos</button>
</form>

<div class="gallery-grid">
<?php
$sql = "SELECT g.image,g.caption,t.name AS team_name FROM gallery g LEFT JOIN teams t ON t.id=g.team_id";
if (!empty($_GET['team_id']) && ctype_digit($_GET['team_id'])) {
  $tid = (int)$_GET['team_id'];
  $sql .= " WHERE g.team_id=$tid";
}
$sql .= " ORDER BY g.uploaded_at DESC";
$res = $mysqli->query($sql);

if($res->num_rows > 0):
  while($g=$res->fetch_assoc()): ?>
  <figure class="gallery-item">
    <img src="../../../admin/uploads/<?php echo sanitize($g['image']); ?>" alt="<?php echo sanitize($g['caption']); ?>">
    <div class="gallery-overlay">
      <div class="gallery-team"><?php echo sanitize($g['team_name'] ?? 'RBL'); ?></div>
      <div class="gallery-caption"><?php echo sanitize($g['caption']); ?></div>
    </div>
  </figure>
<?php endwhile;
else: ?>
  <div class="empty-state">
    <i class="fas fa-camera"></i>
    <h3>No Photos Yet</h3>
    <p>Gallery photos will appear here once uploaded. Check back soon!</p>
  </div>
<?php endif; ?>
</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>


