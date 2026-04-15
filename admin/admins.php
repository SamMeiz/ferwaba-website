<?php
$page_title = 'Admins Management';
require_once __DIR__ . '/includes/admin-header.php';
require_superadmin();

// FIXED VULN-003 & VULN-011: toggle now requires POST + CSRF, uses PDO prepared statement
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['toggle'])) {
    require_csrf_token();
    $tid = (int) ($_POST['toggle'] ?? 0);
    if ($tid && $tid !== (int) $_SESSION['admin_id']) {
        $upd = $db->prepare("UPDATE admins SET is_active = IF(is_active=1,0,1) WHERE id=? LIMIT 1");
        $upd->execute([$tid]);
        audit_log($db, 'Toggle Admin', "Toggled active status for admin ID: $tid");
    }
    header("Location: admins.php");
    exit();
}

$admins = $db->query("SELECT id, full_name, email, role, is_active FROM admins ORDER BY id DESC")->fetchAll();
$csrf_token = generate_csrf_token();
?>

<div class="page-header">
  <div>
    <h1>Admins Management</h1>
    <p>Manage administrator accounts and permissions</p>
  </div>
  <div class="section-actions">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    <a href="admin-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Admin</a>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <h3><i class="fas fa-users-cog"></i> All Administrators</h3>
    <span style="color: var(--gray-500); font-size: 14px;"><?php echo count($admins); ?> admins</span>
  </div>
  <div class="table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th><i class="fas fa-user"></i> Name</th>
          <th><i class="fas fa-envelope"></i> Email</th>
          <th><i class="fas fa-shield-alt"></i> Role</th>
          <th><i class="fas fa-toggle-on"></i> Status</th>
          <th><i class="fas fa-cogs"></i> Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php foreach ($admins as $a): ?>
        <tr>
          <td>
            <div style="display: flex; align-items: center; gap: 10px;">
              <div style="width: 36px; height: 36px; background: var(--primary); color: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-weight: 600;">
                <?php echo strtoupper(substr($a['full_name'], 0, 1)); ?>
              </div>
              <strong><?php echo sanitize($a['full_name']); ?></strong>
            </div>
          </td>
          <td><?php echo sanitize($a['email']); ?></td>
          <td><span class="role-badge"><?php echo sanitize($a['role']); ?></span></td>
          <td>
            <span class="status-badge <?php echo $a['is_active'] ? 'status-active' : 'status-inactive'; ?>">
              <i class="fas fa-circle" style="font-size: 8px;"></i>
              <?php echo $a['is_active'] ? 'Active' : 'Inactive'; ?>
            </span>
          </td>
          <td>
            <div class="action-links">
              <a href="admin-form.php?id=<?php echo (int)$a['id']; ?>" class="action-link edit">
                <i class="fas fa-edit"></i> Edit
              </a>
              <?php if ((int)$a['id'] !== (int)$_SESSION['admin_id']): ?>
              <!-- FIXED VULN-003: was a plain GET link — now a POST form with CSRF token -->
              <form method="post" style="display:inline;" onsubmit="return confirm('Toggle this admin\'s active status?')">
                <input type="hidden" name="csrf_token" value="<?php echo sanitize($csrf_token); ?>">
                <input type="hidden" name="toggle" value="<?php echo (int)$a['id']; ?>">
                <button type="submit" class="action-link <?php echo $a['is_active'] ? 'delete' : 'view'; ?>"
                  style="background:none;border:none;cursor:pointer;padding:0;font:inherit;text-decoration:none;">
                  <i class="fas fa-toggle-<?php echo $a['is_active'] ? 'off' : 'on'; ?>"></i>
                  <?php echo $a['is_active'] ? 'Deactivate' : 'Activate'; ?>
                </button>
              </form>
              <a href="delete-admin.php?id=<?php echo (int)$a['id']; ?>" class="action-link delete"
                onclick="return confirm('Are you sure you want to delete this admin?')">
                <i class="fas fa-trash"></i> Delete
              </a>
              <?php endif; ?>
            </div>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
