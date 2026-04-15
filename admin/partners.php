<?php
$page_title = 'Partners & Sponsors';
require_once __DIR__ . '/includes/admin-header.php';

$message = '';
$message_type = 'message-success';
$csrf_token = generate_csrf_token();

// Handle Secure POST Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_id'])) {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $message = 'Security error: Invalid CSRF token. Please refresh and try again.';
        $message_type = 'message-error';
    } elseif (current_admin_role() !== 'SuperAdmin') {
        $message = 'Security error: Only SuperAdmins can delete partners.';
        $message_type = 'message-error';
    } else {
        $idToDel = (int) $_POST['delete_id'];
        try {
            $stmt = $db->prepare("SELECT name, logo FROM partners WHERE id=?");
            $stmt->execute([$idToDel]);
            $partner = $stmt->fetch();
            if ($partner) {
                // Delete image file if it exists
                if ($partner['logo'] && file_exists(__DIR__ . '/uploads/' . $partner['logo'])) {
                    unlink(__DIR__ . '/uploads/' . $partner['logo']);
                }
                
                $db->prepare("DELETE FROM partners WHERE id=? LIMIT 1")->execute([$idToDel]);
                audit_log($db, 'Delete Partner', "Deleted partner/sponsor: " . $partner['name']);
                
                $message = 'Partner successfully deleted.';
                $message_type = 'message-success';
            }
        } catch (PDOException $e) {
            $message = 'Database error: Could not delete partner.';
            $message_type = 'message-error';
        }
    }
    // Regenerate token after use
    $csrf_token = generate_csrf_token();
}

$partners = [];
try {
    $partners = $db->query("SELECT * FROM partners ORDER BY display_order ASC, name ASC")->fetchAll();
} catch (PDOException $e) {
    error_log("Failed to fetch partners: " . $e->getMessage());
}
?>

<style>
  .page-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 32px;
    padding-bottom: 20px;
    border-bottom: 3px solid var(--gray-200);
    flex-wrap: wrap;
    gap: 20px;
  }

  .page-header h1 {
    font-size: 28px;
    font-weight: 800;
    color: var(--gray-900);
    margin: 0 0 6px 0;
    letter-spacing: -0.5px;
  }

  .page-header p {
    color: var(--gray-600);
    font-size: 15px;
    margin: 0;
  }
  
  .partner-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 24px;
  }

  .partner-card {
    background: #fff;
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-lg);
    overflow: hidden;
    transition: var(--transition);
    display: flex;
    flex-direction: column;
    box-shadow: var(--shadow-sm);
  }

  .partner-card:hover {
    transform: translateY(-4px);
    box-shadow: var(--shadow-md);
    border-color: var(--primary);
  }

  .partner-logo {
    height: 160px;
    background: var(--gray-50);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
    border-bottom: 1px solid var(--gray-100);
  }

  .partner-logo img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
  }

  .partner-info {
    padding: 20px;
    flex: 1;
  }

  .partner-title {
    font-size: 16px;
    font-weight: 800;
    color: var(--gray-900);
    margin-bottom: 8px;
  }

  .partner-meta {
    font-size: 12px;
    color: var(--gray-500);
    margin-bottom: 16px;
  }

  .partner-actions {
    display: flex;
    gap: 8px;
    margin-top: auto;
  }

  .status-badge {
    display: inline-block;
    padding: 4px 8px;
    border-radius: 12px;
    font-size: 10px;
    font-weight: 700;
    text-transform: uppercase;
  }
  .status-active { background: #e6f6ec; color: var(--success); }
  .status-inactive { background: #fef0f0; color: var(--danger); }
</style>

<div class="page-header">
  <div>
    <h1><i class="fas fa-handshake" style="color: var(--primary); margin-right: 12px;"></i>Partners & Sponsors</h1>
    <p>Manage the official sponsors and partners displayed on the frontend.</p>
  </div>
  <div class="section-actions">
    <a href="partner-form" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Sponsor</a>
  </div>
</div>

<?php if ($message): ?>
  <div class="message <?php echo $message_type; ?>">
    <i class="fas <?php echo $message_type === 'message-success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?>"></i>
    <?php echo sanitize($message); ?>
  </div>
<?php endif; ?>

<?php if (count($partners) > 0): ?>
  <div class="partner-grid">
    <?php foreach ($partners as $p): ?>
      <div class="partner-card">
        <div class="partner-logo">
          <?php if ($p['logo']): ?>
            <img src="uploads/<?php echo sanitize($p['logo']); ?>" alt="<?php echo sanitize($p['name']); ?>">
          <?php else: ?>
            <div style="color: var(--gray-400); text-align: center;">
              <i class="fas fa-image fa-3x" style="margin-bottom:8px; display:block;"></i>
              <span style="font-size: 12px;">No Logo Uploaded</span>
            </div>
          <?php endif; ?>
        </div>
        <div class="partner-info">
          <div class="partner-title"><?php echo sanitize($p['name']); ?></div>
          <div class="partner-meta">
            <?php if ($p['website_url']): ?>
              <a href="<?php echo sanitize($p['website_url']); ?>" target="_blank" style="color: var(--primary); text-decoration: none;"><i class="fas fa-external-link-alt"></i> Visitor Link</a><br>
            <?php endif; ?>
            Sort Order: <?php echo (int)$p['display_order']; ?>
          </div>
          
          <div style="margin-bottom: 20px;">
            <span class="status-badge <?php echo $p['is_active'] ? 'status-active' : 'status-inactive'; ?>">
              <?php echo $p['is_active'] ? 'Active' : 'Hidden'; ?>
            </span>
          </div>

          <div class="partner-actions">
            <a href="partner-form?id=<?php echo (int) $p['id']; ?>" class="btn btn-secondary btn-sm" style="flex: 1; text-align: center;"><i class="fas fa-edit"></i> Edit</a>
            
            <!-- SECURE POST DELETION FORM -->
            <form method="POST" onsubmit="return confirm('Are you sure you want to permanently delete this sponsor?');" style="flex: 1;">
               <input type="hidden" name="csrf_token" value="<?php echo sanitize($csrf_token); ?>">
               <input type="hidden" name="delete_id" value="<?php echo (int) $p['id']; ?>">
               <button type="submit" class="btn btn-danger btn-sm" style="width: 100%;"><i class="fas fa-trash"></i> Delete</button>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
<?php else: ?>
  <div class="empty-state" style="background: #fff; padding: 60px 20px; border-radius: var(--radius-lg); text-align: center; border: 2px dashed var(--gray-300);">
    <i class="fas fa-handshake-slash fa-4x" style="color: var(--gray-400); margin-bottom: 20px;"></i>
    <h3 style="font-size: 20px; color: var(--gray-800); margin-bottom: 8px;">No Partners Found</h3>
    <p style="color: var(--gray-600); margin-bottom: 24px;">You haven't added any sponsors or partners to the platform yet.</p>
    <a href="partner-form" class="btn btn-primary"><i class="fas fa-plus"></i> Add Your First Sponsor</a>
  </div>
<?php endif; ?>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
