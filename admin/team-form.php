<?php
$page_title = (isset($_GET['id']) ? 'Edit' : 'Add') . ' Team';
require_once __DIR__ . '/includes/admin-header.php';

$id = isset($_GET['id']) && ctype_digit($_GET['id']) ? (int) $_GET['id'] : 0;
$editing = $id > 0;

$name = '';
$location = '';
$gender = 'Men';
$division = 'Division 1';
$team_group = '';
$logo = '';
$description = '';
$error = '';
$csrf_token = generate_csrf_token();

try {
  if ($editing) {
    $stmt = $db->prepare("SELECT * FROM teams WHERE id = ?");
    $stmt->execute([$id]);
    if ($team = $stmt->fetch()) {
      $name = $team['name'];
      $location = $team['location'];
      $gender = $team['gender'];
      $division = $team['division'];
      $team_group = $team['team_group'] ?? '';
      $logo = $team['logo'];
      $description = $team['description'] ?? '';
    } else {
      echo "<script>window.location.href='teams';</script>";
      exit;
    }
  }

  // Handle Form Submission
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_csrf_token();
    $name = trim($_POST['name'] ?? '');
    $location = trim($_POST['location'] ?? '');
    $gender = $_POST['gender'] ?? 'Men';
    $division = $_POST['division'] ?? 'Division 1';
    $team_group = $division === 'Division 2' ? ($_POST['team_group'] ?? null) : null;
    $description = trim($_POST['description'] ?? '');

    // Handle File Upload
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] !== UPLOAD_ERR_NO_FILE) {
      $allowedExts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
      $allowedMimes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
      $uploadError = validate_upload($_FILES['logo'], $allowedExts, 2097152, $allowedMimes);
      if ($uploadError) {
        $error = $uploadError;
      } else {
        $target_dir = "uploads/";
        if (!file_exists($target_dir)) {
          mkdir($target_dir, 0755, true);
        }
        $file_extension = strtolower(pathinfo($_FILES["logo"]["name"], PATHINFO_EXTENSION));
        $new_filename = generate_safe_filename('team', $file_extension);
        $target_file = $target_dir . $new_filename;
        if (move_uploaded_file($_FILES["logo"]["tmp_name"], $target_file)) {
          $logo = $new_filename;
        } else {
          $error = 'Failed to upload logo.';
        }
      }
    }

    if ($editing) {
      $stmt = $db->prepare("UPDATE teams SET name=?, location=?, gender=?, division=?, team_group=?, logo=?, description=? WHERE id=?");
      $success = $stmt->execute([$name, $location, $gender, $division, $team_group, $logo, $description, $id]);
      if ($success)
        audit_log($db, 'Edit Team', "Updated team: $name (ID: $id)");
    } else {
      $stmt = $db->prepare("INSERT INTO teams (name, location, gender, division, team_group, logo, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
      $success = $stmt->execute([$name, $location, $gender, $division, $team_group, $logo, $description]);
      if ($success) {
        $id = $db->lastInsertId();
        audit_log($db, 'Add Team', "Created team: $name (ID: $id)");
      }
    }

    if ($success) {
      ensure_standings_row($db, $id, $division, $gender, $team_group);
      echo "<div class='message message-success' style='position: fixed; top: 20px; right: 20px; z-index: 1000;'>Team saved successfully!</div>";
      echo "<script>setTimeout(function(){ window.location.href = 'teams'; }, 1500);</script>";
    } else {
      $error = "Failed to save team.";
    }
  }
} catch (PDOException $e) {
  error_log("Team Form Error: " . $e->getMessage());
  $error = "A database error occurred.";
}
?>

<div class="page-header">
  <div>
    <h1><?php echo $editing ? 'Edit Team' : 'Add New Team'; ?></h1>
    <p><?php echo $editing ? 'Update team details and information' : 'Register a new basketball team to the league'; ?>
    </p>
  </div>
  <div class="section-actions">
    <a href="teams" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back to Teams</a>
  </div>
</div>

<div class="form-container">
  <div class="form-header">
    <h2>Team Information</h2>
    <?php if ($editing && $logo): ?>
      <img src="uploads/<?php echo sanitize($logo); ?>" alt="Current Logo"
        style="width: 48px; height: 48px; border-radius: 8px; object-fit: cover; border: 1px solid var(--gray-200);">
    <?php endif; ?>
  </div>

  <?php if (isset($error)): ?>
    <div class="message message-error">
      <i class="fas fa-exclamation-triangle"></i> <?php echo $error; ?>
    </div>
  <?php endif; ?>

  <form method="POST" enctype="multipart/form-data" action="">
    <input type="hidden" name="csrf_token" value="<?php echo sanitize($csrf_token); ?>">
    <div class="form-grid">
      <!-- Name -->
      <div class="form-group required full-width">
        <label for="name">Team Name</label>
        <input type="text" id="name" name="name" class="form-control" value="<?php echo sanitize($name); ?>" required
          placeholder="e.g. Patriots BBC">
      </div>

      <!-- Gender -->
      <div class="form-group required">
        <label for="gender">Gender Category</label>
        <select id="gender" name="gender" class="form-control" required>
          <option value="Men" <?php echo $gender === 'Men' ? 'selected' : ''; ?>>Men</option>
          <option value="Women" <?php echo $gender === 'Women' ? 'selected' : ''; ?>>Women</option>
        </select>
      </div>

      <!-- Division -->
      <div class="form-group required">
        <label for="division">League Division</label>
        <select id="division" name="division" class="form-control" required onchange="toggleGroupDisplay()">
          <option value="Division 1" <?php echo $division === 'Division 1' ? 'selected' : ''; ?>>Division 1</option>
          <option value="Division 2" <?php echo $division === 'Division 2' ? 'selected' : ''; ?>>Division 2</option>
        </select>
      </div>

      <!-- Group (Div 2 only) -->
      <div class="form-group" id="group-container"
        style="<?php echo $division === 'Division 2' ? '' : 'display:none'; ?>">
        <label for="team_group">Group (Division 2)</label>
        <select id="team_group" name="team_group" class="form-control">
          <option value="">Select Group</option>
          <option value="Group A" <?php echo $team_group === 'Group A' ? 'selected' : ''; ?>>Group A</option>
          <option value="Group B" <?php echo $team_group === 'Group B' ? 'selected' : ''; ?>>Group B</option>
        </select>
      </div>

      <!-- Location -->
      <div class="form-group full-width">
        <label for="location">Home Location / City</label>
        <input type="text" id="location" name="location" class="form-control" value="<?php echo sanitize($location); ?>"
          placeholder="e.g. Kigali, Rwanda">
      </div>

      <!-- Description -->
      <div class="form-group full-width">
        <label for="description">Team Bio / Description</label>
        <textarea id="description" name="description" class="form-control" rows="4"
          placeholder="Brief history or description of the team..."><?php echo sanitize($description); ?></textarea>
      </div>

      <!-- Logo Upload -->
      <div class="form-group full-width">
        <label for="logo">Team Logo</label>
        <div class="file-upload-area" onclick="document.getElementById('logo').click()">
          <i class="fas fa-cloud-upload-alt"></i>
          <h4>Click to upload logo</h4>
          <p>PNG, JPG, GIF or WEBP (Max. 2MB)</p>
          <input type="file" id="logo" name="logo" accept="image/*" style="display: none;"
            onchange="updateFileName(this)">
          <p id="file-name" style="margin-top: 10px; font-weight: 600; color: var(--primary); display: none;"></p>
        </div>
      </div>
    </div>

    <div class="form-actions">
      <a href="teams" class="btn btn-secondary">Cancel</a>
      <button type="submit" class="btn btn-primary">
        <i class="fas fa-save"></i> <?php echo $editing ? 'Update Team' : 'Create Team'; ?>
      </button>
    </div>
  </form>
</div>

<script>
  function toggleGroupDisplay() {
    const division = document.getElementById('division').value;
    const groupContainer = document.getElementById('group-container');
    if (division === 'Division 2') {
      groupContainer.style.display = 'block';
    } else {
      groupContainer.style.display = 'none';
      document.getElementById('team_group').value = '';
    }
  }

  function updateFileName(input) {
    const fileNameDisplay = document.getElementById('file-name');
    if (input.files && input.files[0]) {
      fileNameDisplay.textContent = 'Selected: ' + input.files[0].name;
      fileNameDisplay.style.display = 'block';
    } else {
      fileNameDisplay.style.display = 'none';
    }
  }
</script>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>
