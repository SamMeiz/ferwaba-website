<?php 
require_once __DIR__ . '/../includes/config.php';
require_login();

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
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Shop - FERWABA</title>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .team-folder { margin-bottom: 32px; }
    .team-folder h3 {
      margin-bottom: 12px;
      padding: 8px 12px;
      background: var(--blue);
      color: #fff;
      border-radius: 6px;
      display: inline-block;
    }
    .shop-grid {
      display: grid;
      grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
      gap: 16px;
    }
    .shop-item {
      border: 1px solid #ddd;
      border-radius: 8px;
      overflow: hidden;
      background: #fff;
      transition: transform 0.2s;
    }
    .shop-item:hover { transform: scale(1.02); }
    .shop-item img {
      width: 100%;
      height: 150px;
      object-fit: cover;
    }
    .shop-item .info {
      padding: 10px;
    }
    .shop-item .info h4 {
      margin: 0;
      font-size: 16px;
      font-weight: 600;
    }
    .shop-item .info .muted {
      color: #666;
      font-size: 14px;
    }
  </style>
</head>
<body>
<div class="container" style="margin:20px auto">
  <div class="section-title">
    <h2>Shop Management</h2>
    <a href="javascript:history.back()" class="btn" style="background:#6b7280;margin-left:8px;">⬅️ Back</a>
    <a class="btn" href="shop-form.php">Add Item</a>
  </div>

  <?php
  $currentTeam = null;
  while ($i = $rows->fetch_assoc()):
    $teamName = $teams[$i['team_id']] ?? 'Unassigned';
    
    // When team changes, close previous table and start a new one
    if ($teamName !== $currentTeam):
      if ($currentTeam !== null) echo '</tbody></table></div>'; // close previous folder
      echo '<div class="team-folder">';
      echo '<h3>' . htmlspecialchars($teamName) . '</h3>';
      echo '<div class="card"><table>';
      echo '<thead><tr><th>Image</th><th>Name</th><th>Category</th><th>Gender</th><th>Price</th><th>Status</th><th>Actions</th></tr></thead><tbody>';
      $currentTeam = $teamName;
    endif;
  ?>
    <tr>
      <td><?php if($i['image']): ?><img src="/ferwaba1/admin/uploads/<?php echo sanitize($i['image']); ?>" alt="img" style="width:48px;height:32px;object-fit:cover"><?php endif; ?></td>
      <td><?php echo sanitize($i['name']); ?></td>
      <td><?php echo sanitize($i['category']); ?></td>
      <td><?php echo sanitize($i['gender']); ?></td>
      <td>RWF <?php echo number_format((float)$i['price'], 2); ?></td>
      <td><?php echo $i['is_active'] ? 'Active' : 'Inactive'; ?></td>
      <td>
        <a href="shop-form.php?id=<?php echo (int)$i['id']; ?>">Edit</a> |
        <a href="delete-shop.php?id=<?php echo (int)$i['id']; ?>" onclick="return confirm('Delete this item?')">Delete</a>
      </td>
    </tr>
  <?php endwhile; ?>

  <?php if ($currentTeam !== null) echo '</tbody></table></div></div>'; ?>
</div>
</body>
</html>
