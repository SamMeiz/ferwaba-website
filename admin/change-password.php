<?php
$page_title = 'Change Password';
require_once __DIR__ . '/includes/admin-header.php';

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
    try {
      $admin_id = (int) $_SESSION['admin_id'];
      $stmt = $db->prepare("SELECT password, full_name FROM admins WHERE id=? LIMIT 1");
      $stmt->execute([$admin_id]);
      $admin = $stmt->fetch();

      if ($admin) {
        if (verify_password($current_password, $admin['password'])) {
          $hashed_new = hash_password($new_password);
          $update_stmt = $db->prepare("UPDATE admins SET password=? WHERE id=? LIMIT 1");

          if ($update_stmt->execute([$hashed_new, $admin_id])) {
            audit_log($db, 'Change Password', "Administrator changed their password: {$admin['full_name']} (ID: $admin_id)");
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
    } catch (PDOException $e) {
      error_log("Change Password Error: " . $e->getMessage());
      $error = 'A database error occurred.';
    }
  }
}
?>

<div class="page-header">
  <div>
    <h1>Change Password</h1>
    <p>Update your account password</p>
  </div>
  <div class="section-actions">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
  </div>
</div>

<?php if ($error): ?>
  <div class="message message-error">
    <i class="fas fa-exclamation-circle"></i>
    <?php echo sanitize($error); ?>
  </div>
<?php endif; ?>

<?php if ($success): ?>
  <div class="message message-success">
    <i class="fas fa-check-circle"></i>
    <?php echo sanitize($success); ?>
  </div>
<?php endif; ?>

<div class="form-container" style="max-width: 500px;">
  <form method="post">
    <div class="form-group">
      <label for="current_password"><i class="fas fa-lock"></i> Current Password</label>
      <input type="password" id="current_password" name="current_password" required autocomplete="current-password"
        placeholder="Enter current password">
    </div>

    <div class="form-group">
      <label for="new_password"><i class="fas fa-key"></i> New Password</label>
      <input type="password" id="new_password" name="new_password" required autocomplete="new-password" minlength="6"
        placeholder="Enter new password">
      <span class="form-hint"><i class="fas fa-info-circle"></i> Minimum 6 characters</span>
    </div>

    <div class="form-group">
      <label for="confirm_password"><i class="fas fa-check-double"></i> Confirm New Password</label>
      <input type="password" id="confirm_password" name="confirm_password" required autocomplete="new-password"
        minlength="6" placeholder="Confirm new password">
    </div>

    <div class="form-actions">
      <button type="submit" class="btn btn-success">
        <i class="fas fa-save"></i>
        Change Password
      </button>
      <a href="dashboard.php" class="btn btn-secondary">
        <i class="fas fa-times"></i>
        Cancel
      </a>
    </div>
  </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
