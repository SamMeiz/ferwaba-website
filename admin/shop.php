<?php
$page_title = 'Shop Management';
require_once __DIR__ . '/includes/admin-header.php';

// Fetch all teams (for grouping)
$teams = [];
$tres = $mysqli->query("SELECT id, name FROM teams ORDER BY name ASC");
while ($t = $tres->fetch_assoc()) {
  $teams[$t['id']] = $t['name'];
}

// Fetch shop items
$rows = $mysqli->query("
  SELECT id, name, category, price, image, is_active, created_at, team_id, gender
  FROM shop_items
  ORDER BY team_id ASC, created_at DESC
");

$itemsByTeam = [];
while ($i = $rows->fetch_assoc()) {
  $teamName = $teams[$i['team_id']] ?? 'Unassigned';
  $itemsByTeam[$teamName][] = $i;
}
?>

<style>
.shop-item-card {
  background: #fff;
  border-radius: var(--radius);
  overflow: hidden;
  box-shadow: var(--shadow);
  transition: all 0.3s ease;
}
.shop-item-card:hover {
  transform: translateY(-4px);
  box-shadow: var(--shadow-lg);
}
.shop-item-image {
  width: 100%;
  height: 140px;
  object-fit: cover;
}
.shop-item-info {
  padding: 14px;
}
.shop-item-info h4 {
  font-size: 14px;
  font-weight: 600;
  color: var(--gray-800);
  margin-bottom: 6px;
}
.shop-item-meta {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 10px;
}
.shop-item-price {
  font-weight: 700;
  color: var(--primary);
  font-size: 16px;
}
.shop-items-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
  gap: 16px;
}
.team-section {
  margin-bottom: 32px;
}
.team-section h3 {
  font-size: 16px;
  font-weight: 600;
  color: var(--gray-700);
  margin-bottom: 16px;
  padding-bottom: 8px;
  border-bottom: 2px solid var(--gray-200);
}
</style>

<div class="page-header">
  <div>
    <h1>Shop Management</h1>
    <p>Manage merchandise and products</p>
  </div>
  <div class="section-actions">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    <a href="shop-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Item</a>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-body">
    <?php if (empty($itemsByTeam)): ?>
      <div class="empty-state">
        <i class="fas fa-shopping-bag"></i>
        <h3>No shop items found</h3>
        <p>Add your first product to the shop.</p>
        <a href="shop-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Item</a>
      </div>
    <?php else: ?>
      <?php foreach ($itemsByTeam as $teamName => $items): ?>
        <div class="team-section">
          <h3><i class="fas fa-tag"></i> <?php echo sanitize($teamName); ?></h3>
          <div class="shop-items-grid">
            <?php foreach ($items as $i): ?>
              <div class="shop-item-card">
                <?php if ($i['image']): ?>
                  <img src="uploads/<?php echo sanitize($i['image']); ?>" alt="<?php echo sanitize($i['name']); ?>" class="shop-item-image">
                <?php else: ?>
                  <div class="shop-item-image" style="background: var(--gray-200); display: flex; align-items: center; justify-content: center;">
                    <i class="fas fa-image" style="color: var(--gray-400); font-size: 32px;"></i>
                  </div>
                <?php endif; ?>
                <div class="shop-item-info">
                  <h4><?php echo sanitize($i['name']); ?></h4>
                  <div class="shop-item-meta">
                    <span class="shop-item-price">RWF <?php echo number_format((float)$i['price'], 0); ?></span>
                    <span class="status-badge <?php echo $i['is_active'] ? 'status-active' : 'status-inactive'; ?>">
                      <?php echo $i['is_active'] ? 'Active' : 'Inactive'; ?>
                    </span>
                  </div>
                  <div style="display: flex; gap: 8px;">
                    <a href="shop-form.php?id=<?php echo (int)$i['id']; ?>" class="action-link edit">
                      <i class="fas fa-edit"></i> Edit
                    </a>
                    <a href="delete-shop.php?id=<?php echo (int)$i['id']; ?>" class="action-link delete" onclick="return confirm('Delete this item?')">
                      <i class="fas fa-trash"></i> Delete
                    </a>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
