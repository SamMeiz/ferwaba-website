<?php
require_once __DIR__ . '/../includes/bootstrap.php';

if (is_logged_in()) {
  header("Location: dashboard.php");
  exit();
}

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $email = trim($_POST['email'] ?? '');
  $password = trim($_POST['password'] ?? '');
  $ip = client_ip();

  if (is_ip_rate_limited($db, $ip, 20, 300)) {
    $error = 'Too many login attempts from your IP. Please try again in 5 minutes.';
    log_login_attempt($db, $ip, false);
    audit_log($db, 'Failed Login', 'Rate limited login attempt from: ' . $ip);
  } elseif (!check_rate_limit('login_attempt', 5, 300)) {
    $error = 'Too many login attempts. Please try again in 5 minutes.';
  } elseif ($email && $password) {
    $stmt = $db->prepare("SELECT id, full_name, password, role, is_active FROM admins WHERE email=? LIMIT 1");
    $stmt->execute([$email]);
    if ($admin = $stmt->fetch()) {
      if ((int) $admin['is_active'] !== 1) {
        $error = 'Account is inactive. Please contact SuperAdmin.';
        log_login_attempt($db, $ip, false);
        audit_log($db, 'Failed Login', 'Inactive account login attempt for: ' . $email);
      } elseif (verify_password($password, $admin['password'])) {
        $stored_hash = $admin['password'];
        $info = password_get_info($stored_hash);
        $needs_upgrade = false;
        if (empty($info['algo'])) {
          $needs_upgrade = true;
        } elseif (password_needs_rehash($stored_hash, PASSWORD_BCRYPT)) {
          $needs_upgrade = true;
        }
        if ($needs_upgrade) {
          $new_hash = hash_password($password);
          $upd = $db->prepare("UPDATE admins SET password=? WHERE id=? LIMIT 1");
          $upd->execute([$new_hash, $admin['id']]);
        }

        session_regenerate_id(true);

        $_SESSION['admin_id'] = (int) $admin['id'];
        $_SESSION['admin_name'] = $admin['full_name'];
        $_SESSION['admin_role'] = $admin['role'];

        log_login_attempt($db, $ip, true);
        audit_log($db, 'Login', 'Admin logged in: ' . $email);

        header("Location: dashboard.php");
        exit();
      } else {
        $error = 'Invalid email or password.';
        log_login_attempt($db, $ip, false);
        audit_log($db, 'Failed Login', 'Incorrect password for: ' . $email);
      }
    } else {
      $error = 'Invalid email or password.';
      log_login_attempt($db, $ip, false);
      audit_log($db, 'Failed Login', 'User not found: ' . $email);
    }
  } else {
    $error = 'Please enter both email and password.';
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Login - FERWABA</title>
  <link rel="stylesheet" href="../assets/css/admin.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>

<body class="login-body">
  <div class="login-container">
    <div class="login-card">
      <div class="login-header">
        <div class="logo">
          <i class="fas fa-basketball-ball"></i>
          <span>FERWABA</span>
        </div>
        <p>Admin Panel Login</p>
      </div>
      <div class="login-body-content">
        <?php if ($error): ?>
          <div class="login-error">
            <i class="fas fa-exclamation-circle"></i>
            <?php echo sanitize($error); ?>
          </div>
        <?php endif; ?>

        <form method="post">
          <div class="form-group">
            <label for="email"><i class="fas fa-envelope"></i> Email Address</label>
            <input type="email" id="email" name="email" placeholder="admin@ferwaba.rw" required
              value="<?php echo sanitize($_POST['email'] ?? ''); ?>">
          </div>

          <div class="form-group">
            <label for="password"><i class="fas fa-lock"></i> Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
          </div>

          <button type="submit" class="btn btn-primary">
            <i class="fas fa-sign-in-alt"></i>
            Sign In
          </button>
        </form>

        <div style="text-align: center; margin-top: 24px; display: flex; justify-content: center; gap: 24px;">
          <a href="../ferwaba-main/index.php"
            style="color: var(--gray-600); font-size: 13px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 6px; transition: color 0.2s;">
            <i class="fas fa-arrow-left"></i> Back to FERWABA
          </a>
          <a href="../competitions/rbl/pages/index.php"
            style="color: var(--primary); font-size: 13px; text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 6px; transition: color 0.2s;">
            <i class="fas fa-basketball-ball"></i> Back to RBL
          </a>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
