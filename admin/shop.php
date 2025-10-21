<?php require_once __DIR__ . '/../includes/config.php';
require_login();

$rows = $mysqli->query("SELECT id,name,category,price,image,is_active,created_at FROM shop_items ORDER BY created_at DESC, id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Manage Shop - FERWABA</title>
  <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<div class="container" style="margin:20px auto">
  <div class="section-title">
    <h2>Shop</h2>
    <a href="javascript:history.back()" class="btn" style="background:#6b7280;margin-left:8px;">⬅️ Back</a>
    <a class="btn" href="shop-form.php">Add Item</a>
  </div>
  <div class="card">
    <table>
      <thead><tr><th>Image</th><th>Name</th><th>Category</th><th>Price</th><th>Status</th><th>Actions</th></tr></thead>
      <tbody>
        <?php while($i=$rows->fetch_assoc()): ?>
        <tr>
          <td><?php if($i['image']): ?><img src="/admin/uploads/<?php echo sanitize($i['image']); ?>" alt="img" style="width:48px;height:32px;object-fit:cover;border-radius:6px"><?php endif; ?></td>
          <td><?php echo sanitize($i['name']); ?></td>
          <td><?php echo sanitize($i['category']); ?></td>
          <td>RWF <?php echo number_format((float)$i['price'],2); ?></td>
          <td><?php echo $i['is_active']? 'Active':'Inactive'; ?></td>
          <td>
            <a href="shop-form.php?id=<?php echo (int)$i['id']; ?>">Edit</a>
            <a href="delete-shop.php?id=<?php echo (int)$i['id']; ?>" onclick="return confirm('Delete item?')">Delete</a>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>


