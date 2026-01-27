<?php
$page_title = 'Gallery Management';
require_once __DIR__ . '/includes/admin-header.php';

$selectedGender = $_GET['gender'] ?? 'All';
$selectedType = $_GET['type'] ?? 'All';

$imgs = $mysqli->query("
    SELECT g.id, g.image, g.caption,
           t.name AS team_name, t.gender, t.division,
           nt.team_name AS nteam_name, nt.category
    FROM gallery g
    LEFT JOIN teams t ON t.id = g.team_id
    LEFT JOIN national_teams nt ON nt.id = g.team_id
    ORDER BY COALESCE(t.name, nt.team_name) ASC
");

$galleryByTeam = [];
while ($g = $imgs->fetch_assoc()) {
    $isNational = !empty($g['nteam_name']);
    $team = $isNational ? $g['nteam_name'] : $g['team_name'];
    $gender = $isNational
        ? (strpos($g['category'], 'Women') !== false ? 'Women' : 'Men')
        : ($g['gender'] ?? '');
    $type = $isNational ? 'National Teams' : 'Division Teams';

    if ($selectedGender !== 'All' && $gender !== $selectedGender) continue;
    if ($selectedType !== 'All' && $type !== $selectedType) continue;

    $galleryByTeam[$team][] = [
        'id' => $g['id'],
        'image' => $g['image'],
        'caption' => $g['caption'],
        'gender' => $gender,
        'type' => $type,
    ];
}
?>

<style>
.gallery-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
  gap: 16px;
  margin-top: 20px;
}
.gallery-item {
  background: #fff;
  border-radius: var(--radius);
  overflow: hidden;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
}
.gallery-item:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lg);
}
.gallery-item img {
  width: 100%;
  aspect-ratio: 1;
  object-fit: cover;
}
.gallery-item-body {
  padding: 12px;
}
.gallery-item-caption {
  font-size: 12px;
  color: var(--gray-600);
  margin-bottom: 8px;
  display: -webkit-box;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
  overflow: hidden;
}
.gallery-filter {
  display: flex;
  gap: 12px;
  align-items: center;
  margin-bottom: 20px;
  flex-wrap: wrap;
}
.gallery-filter label {
  font-weight: 500;
  color: var(--gray-700);
}
.gallery-filter select {
  padding: 8px 12px;
  border: 2px solid var(--gray-200);
  border-radius: var(--radius);
  font-size: 14px;
  background: #fff;
  cursor: pointer;
}
.gallery-filter select:focus {
  outline: none;
  border-color: var(--primary);
}
</style>

<div class="page-header">
  <div>
    <h1>Gallery Management</h1>
    <p>Manage photos and media</p>
  </div>
  <div class="section-actions">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    <a href="gallery-form.php" class="btn btn-primary"><i class="fas fa-upload"></i> Upload Photo</a>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-body">
    <form method="get" class="gallery-filter">
      <label><i class="fas fa-venus-mars"></i> Gender:</label>
      <select name="gender" onchange="this.form.submit()">
        <option value="All" <?php echo $selectedGender === 'All' ? 'selected' : ''; ?>>All</option>
        <option value="Men" <?php echo $selectedGender === 'Men' ? 'selected' : ''; ?>>Men</option>
        <option value="Women" <?php echo $selectedGender === 'Women' ? 'selected' : ''; ?>>Women</option>
      </select>

      <label><i class="fas fa-users"></i> Team Type:</label>
      <select name="type" onchange="this.form.submit()">
        <option value="All" <?php echo $selectedType === 'All' ? 'selected' : ''; ?>>All</option>
        <option value="Division Teams" <?php echo $selectedType === 'Division Teams' ? 'selected' : ''; ?>>Division Teams</option>
        <option value="National Teams" <?php echo $selectedType === 'National Teams' ? 'selected' : ''; ?>>National Teams</option>
      </select>
    </form>

    <?php if (empty($galleryByTeam)): ?>
      <div class="empty-state">
        <i class="fas fa-images"></i>
        <h3>No photos found</h3>
        <p>Try adjusting your filters or upload new photos.</p>
      </div>
    <?php else: ?>
      <?php foreach ($galleryByTeam as $team => $images): ?>
        <h3 style="margin: 24px 0 16px; font-size: 16px; font-weight: 600; color: var(--gray-700);">
          <i class="fas fa-folder"></i> <?php echo sanitize($team); ?>
          <span style="color: var(--gray-500); font-weight: 400; font-size: 14px;">(<?php echo count($images); ?>)</span>
        </h3>
        <div class="gallery-grid">
          <?php foreach ($images as $g): ?>
            <div class="gallery-item">
              <img src="uploads/<?php echo sanitize($g['image']); ?>" alt="gallery image">
              <div class="gallery-item-body">
                <?php if (!empty($g['caption'])): ?>
                  <p class="gallery-item-caption"><?php echo sanitize($g['caption']); ?></p>
                <?php endif; ?>
                <a href="delete-gallery.php?id=<?php echo (int)$g['id']; ?>" class="action-link delete" onclick="return confirm('Delete this image?')">
                  <i class="fas fa-trash"></i> Delete
                </a>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
