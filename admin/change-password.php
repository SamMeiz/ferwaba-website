<?php require_once __DIR__ . '/../includes/config.php';
require_login();
require_superadmin();

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $current_password = trim($_POST['current_password'] ?? '');
    $new_password = trim($_POST['new_password'] ?? '');
    $confirm_password = trim($_POST['confirm_password'] ?? '');
    
    if (!$current_password || !$new_password || !$confirm_password) {
        $error = 'All fields are required.';
    } elseif ($new_password !== $confirm_password) {
        $error = 'New password and confirm password do not match.';
    } elseif (strlen($new_password) < 6) {
        $error = 'New password must be at least 6 characters long.';
    } else {
        // Verify current password
        $admin_id = (int)$_SESSION['admin_id'];
        $stmt = $mysqli->prepare("SELECT password FROM admins WHERE id=? LIMIT 1");
        $stmt->bind_param('i', $admin_id);
        $stmt->execute();
        $res = $stmt->get_result();
        
        if ($admin = $res->fetch_assoc()) {
            if (hash_password($current_password) === $admin['password']) {
                // Update password
                $hashed_new = hash_password($new_password);
                $update_stmt = $mysqli->prepare("UPDATE admins SET password=? WHERE id=? LIMIT 1");
                $update_stmt->bind_param('si', $hashed_new, $admin_id);
                
                if ($update_stmt->execute()) {
                    $success = 'Password changed successfully!';
                    $current_password = $new_password = $confirm_password = '';
                } else {
                    $error = 'Failed to update password. Please try again.';
                }
            } else {
                $error = 'Current password is incorrect.';
            }
        } else {
            $error = 'Admin account not found.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password - FERWABA Admin</title>
  <link rel="stylesheet" href="<?php echo asset_url('../css/admin.css'); ?>">
</head>
<body>
<div class="container" style="max-width:600px;margin:40px auto">
  <div class="admin-header">
    <h1>Change Password</h1>
    <div class="admin-nav">
      <a href="dashboard.php" class="btn btn-secondary">Back to Dashboard</a>
      <a href="logout.php" class="btn btn-danger">Logout</a>
    </div>
  </div>
  
  <div class="card">
    <div class="card-body">
      <h2 style="margin:0 0 20px">Change Super Admin Password</h2>
      
      <?php if($error): ?>
        <div class="error"><?php echo sanitize($error); ?></div>
      <?php endif; ?>
      
      <?php if($success): ?>
        <div class="success"><?php echo sanitize($success); ?></div>
      <?php endif; ?>
      
      <form method="post">
        <div class="form-group">
          <label>Current Password</label>
          <input type="password" name="current_password" required autocomplete="current-password">
        </div>
        
        <div class="form-group">
          <label>New Password</label>
          <input type="password" name="new_password" required autocomplete="new-password" minlength="6">
          <small class="muted">Minimum 6 characters</small>
        </div>
        
        <div class="form-group">
          <label>Confirm New Password</label>
          <input type="password" name="confirm_password" required autocomplete="new-password" minlength="6">
        </div>
        
        <div class="action-buttons">
          <button type="submit" class="btn btn-success">Change Password</button>
          <a href="dashboard.php" class="btn btn-secondary">Cancel</a>
        </div>
      </form>
    </div>
  </div>
</div>
</body>
</html>

