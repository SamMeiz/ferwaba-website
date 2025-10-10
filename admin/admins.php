<?php require_once __DIR__ . '/../includes/config.php';
require_login();
require_superadmin();

// Handle activation toggle
if (isset($_GET['toggle']) && ctype_digit($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    if ($id === (int)($_SESSION['admin_id'])) {
        die('Cannot deactivate self');
    }
    $mysqli->query("UPDATE admins SET is_active = IF(is_active=1,0,1) WHERE id=$id");
    redirect('/admin/admins.php');
}

// Handle delete (prevent self)
if (isset($_GET['delete']) && ctype_digit($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    if ($id === (int)($_SESSION['admin_id'])) {
        die('Cannot delete yourself');
    }
    $stmt = $mysqli->prepare("DELETE FROM admins WHERE id=? LIMIT 1");
    $stmt->bind_param('i', $id);
    $stmt->execute();
    redirect('/admin/admins.php');
}

$admins = $mysqli->query("SELECT id, full_name, email, role, is_active FROM admins ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admins - FERWABA</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/style.css'); ?>">
  <style>.table-actions a{margin-right:8px}</style>
  </head>
<body>
<div class="container" style="margin:20px auto">
  <div class="section-title">
    <h2>Admins</h2>
    <a class="btn" href="/admin/admin-form.php">Add Admin</a>
  </div>
  <div class="card">
    <table>
      <thead>
        <tr><th>Name</th><th>Email</th><th>Role</th><th>Status</th><th>Actions</th></tr>
      </thead>
      <tbody>
        <?php while($a = $admins->fetch_assoc()): ?>
        <tr>
          <td><?php echo sanitize($a['full_name']); ?></td>
          <td><?php echo sanitize($a['email']); ?></td>
          <td><?php echo sanitize($a['role']); ?></td>
          <td><?php echo $a['is_active']? 'Active':'Inactive'; ?></td>
          <td class="table-actions">
            <a href="/admin/admin-form.php?id=<?php echo (int)$a['id']; ?>">Edit</a>
            <?php if((int)$a['id'] !== (int)$_SESSION['admin_id']): ?>
            <a href="/admin/admins.php?toggle=<?php echo (int)$a['id']; ?>">Toggle</a>
            <a href="/admin/delete-admin.php?id=<?php echo (int)$a['id'];  ?>" onclick="return confirm('Delete admin?')">Delete</a>
            <?php endif; ?>
          </td>
        </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</div>
</body>
</html>


