<?php
$page_title = 'Partner/Sponsor Form';
require_once __DIR__ . '/includes/admin-header.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$partner = null;
$message = '';
$message_type = 'message-success';
$csrf_token = generate_csrf_token();

if ($id > 0) {
    try {
        $stmt = $db->prepare("SELECT * FROM partners WHERE id = ?");
        $stmt->execute([$id]);
        $partner = $stmt->fetch();
        if (!$partner) {
            redirect('partners.php');
        }
    } catch (PDOException $e) {
        error_log("Fetch partner error: " . $e->getMessage());
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf_token();

    $name = trim($_POST['name'] ?? '');
    $website_url = trim($_POST['website_url'] ?? '');
    $display_order = (int) ($_POST['display_order'] ?? 0);
    $is_active = isset($_POST['is_active']) ? 1 : 0;

    if (empty($name)) {
        $message = 'Sponsor name is required.';
        $message_type = 'message-error';
    } else {
        $logo = $partner ? $partner['logo'] : null;

        // Handle Image Upload
        if (!empty($_FILES['logo']['name'])) {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg'];
            $allowedMimeTypes = ['image/jpeg', 'image/png', 'image/webp', 'image/svg+xml'];
            $uploadError = validate_upload($_FILES['logo'], $allowedExtensions, 5 * 1024 * 1024, $allowedMimeTypes);

            if ($uploadError) {
                $message = $uploadError;
                $message_type = 'message-error';
            } else {
                $ext = strtolower(pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION));
                $newLogoName = generate_safe_filename('sponsor', $ext);
                $uploadPath = __DIR__ . '/uploads/' . $newLogoName;

                if (!is_dir(__DIR__ . '/uploads/')) {
                    mkdir(__DIR__ . '/uploads/', 0755, true);
                }

                if (move_uploaded_file($_FILES['logo']['tmp_name'], $uploadPath)) {
                    // Delete old logo
                    if ($logo && file_exists(__DIR__ . '/uploads/' . $logo)) {
                        unlink(__DIR__ . '/uploads/' . $logo);
                    }
                    $logo = $newLogoName;
                } else {
                    $message = 'Failed to save uploaded image.';
                    $message_type = 'message-error';
                }
            }
        }

        if (!$message) {
            try {
                if ($id > 0) {
                    $stmt = $db->prepare("UPDATE partners SET name=?, logo=?, website_url=?, display_order=?, is_active=? WHERE id=?");
                    $stmt->execute([$name, $logo, $website_url, $display_order, $is_active, $id]);
                    audit_log($db, 'Update Partner', "Updated sponsor: $name");
                    $message = 'Sponsor updated successfully.';
                    // Update current data so form stays fresh without reload
                    $partner = [
                        'id' => $id,
                        'name' => $name,
                        'logo' => $logo,
                        'website_url' => $website_url,
                        'display_order' => $display_order,
                        'is_active' => $is_active
                    ];
                } else {
                    $stmt = $db->prepare("INSERT INTO partners (name, logo, website_url, display_order, is_active) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$name, $logo, $website_url, $display_order, $is_active]);
                    $new_id = $db->lastInsertId();
                    audit_log($db, 'Create Partner', "Added new sponsor: $name");
                    redirect('partner-form.php?id=' . $new_id . '&success=1');
                }
            } catch (PDOException $e) {
                $message = 'Database error occurred while saving.';
                $message_type = 'message-error';
                error_log("Save Partner Error: " . $e->getMessage());
            }
        }
    }
}

if (isset($_GET['success']) && !$message) {
    $message = 'Sponsor added successfully.';
    $message_type = 'message-success';
}
?>

<div class="page-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 32px; border-bottom: 3px solid var(--gray-200); padding-bottom: 20px;">
  <div>
    <h1 style="font-size: 28px; font-weight: 800; color: var(--gray-900); margin: 0 0 6px 0;"><i class="fas <?php echo $partner ? 'fa-edit' : 'fa-plus-circle'; ?>" style="color: var(--primary); margin-right: 12px;"></i><?php echo $partner ? 'Edit Sponsor' : 'Add New Sponsor'; ?></h1>
    <a href="partners" style="color: var(--gray-500); text-decoration: none; font-size: 14px; font-weight: 600;"><i class="fas fa-arrow-left"></i> Back to Partners List</a>
  </div>
</div>

<?php if ($message): ?>
  <div class="message <?php echo $message_type; ?>">
    <i class="fas <?php echo $message_type === 'message-success' ? 'fa-check-circle' : 'fa-exclamation-triangle'; ?>"></i>
    <?php echo sanitize($message); ?>
  </div>
<?php endif; ?>

<div class="admin-card" style="max-width: 800px; padding: 40px; border-radius: var(--radius-lg); background: #fff; box-shadow: var(--shadow-sm);">
  <form method="post" enctype="multipart/form-data">
    <input type="hidden" name="csrf_token" value="<?php echo sanitize($csrf_token); ?>">

    <div class="form-row" style="margin-bottom: 24px;">
      <label style="display: block; font-weight: 700; color: var(--gray-800); margin-bottom: 8px;">Sponsor / Partner Name <span style="color: var(--danger);">*</span></label>
      <input type="text" name="name" required style="width: 100%; padding: 14px 16px; border: 2px solid var(--gray-300); border-radius: 8px; font-size: 15px;"
        value="<?php echo sanitize($_POST['name'] ?? ($partner['name'] ?? '')); ?>" placeholder="e.g. Visit Rwanda">
    </div>

    <div class="form-row" style="margin-bottom: 24px;">
      <label style="display: block; font-weight: 700; color: var(--gray-800); margin-bottom: 8px;">Website URL</label>
      <input type="url" name="website_url" style="width: 100%; padding: 14px 16px; border: 2px solid var(--gray-300); border-radius: 8px; font-size: 15px;"
        value="<?php echo sanitize($_POST['website_url'] ?? ($partner['website_url'] ?? '')); ?>" placeholder="https://www.example.com">
      <small style="color: var(--gray-500); display: block; margin-top: 6px;">Used to link the sponsor logo on the frontend to their site.</small>
    </div>

    <div class="form-row" style="margin-bottom: 24px;">
       <label style="display: block; font-weight: 700; color: var(--gray-800); margin-bottom: 8px;">Sponsor Logo (Image)</label>
       <?php if ($partner && $partner['logo']): ?>
          <div style="margin-bottom: 16px; padding: 16px; background: var(--gray-50); border-radius: 8px; display: inline-block;">
             <img src="uploads/<?php echo sanitize($partner['logo']); ?>" style="max-height: 100px; display: block; margin-bottom: 8px;">
             <span style="font-size: 12px; color: var(--gray-600);"><i class="fas fa-check-circle" style="color: var(--success);"></i> Current Logo securely stored</span>
          </div>
       <?php endif; ?>
       <input type="file" name="logo" accept=".jpg,.jpeg,.png,.webp,.svg" style="display: block; width: 100%;">
       <small style="color: var(--gray-500); display: block; margin-top: 6px;">Recommended: Transparent PNG or highly legible SVG format.</small>
    </div>

    <hr style="border: 0; border-bottom: 2px solid var(--gray-100); margin: 32px 0;">

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 32px;">
       <div class="form-row">
         <label style="display: block; font-weight: 700; color: var(--gray-800); margin-bottom: 8px;">Display Order</label>
         <input type="number" name="display_order" min="0" style="width: 100%; padding: 14px 16px; border: 2px solid var(--gray-300); border-radius: 8px; font-size: 15px;"
           value="<?php echo sanitize($_POST['display_order'] ?? ($partner['display_order'] ?? '0')); ?>">
         <small style="color: var(--gray-500); display: block; margin-top: 6px;">Lower numbers show first (e.g. 0, 1, 2...)</small>
       </div>

       <div class="form-row" style="display: flex; align-items: center; gap: 12px; padding-top: 36px;">
         <input type="checkbox" name="is_active" id="is_active" style="width: 24px; height: 24px; accent-color: var(--primary);"
           <?php 
             $activeCheck = $_POST['is_active'] ?? ($partner['is_active'] ?? '1');
             echo $activeCheck ? 'checked' : ''; 
           ?>>
         <label for="is_active" style="font-weight: 700; color: var(--gray-800); cursor: pointer;">Sponsor is Active (Visible on site)</label>
       </div>
    </div>

    <div class="form-actions" style="display: flex; gap: 16px;">
      <button type="submit" class="btn btn-primary" style="padding: 16px 32px; font-size: 16px; font-weight: 700;">
         <i class="fas fa-save"></i> <?php echo $partner ? 'Save Changes' : 'Publish Sponsor'; ?>
      </button>
      <a href="partners" class="btn btn-secondary" style="padding: 16px 32px; font-size: 16px; font-weight: 700; background: var(--gray-200); color: var(--gray-800);">Cancel</a>
    </div>

  </form>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
