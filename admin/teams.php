<?php
$page_title = 'Teams Management';
require_once __DIR__ . '/includes/admin-header.php';

$csrf_token = generate_csrf_token();
$msg_flash = $_GET['msg'] ?? '';

// Filtering logic
$where_clauses = [];
$params = [];

$filter_division = $_GET['division'] ?? '';
$filter_gender = $_GET['gender'] ?? '';

if ($filter_division) {
  $where_clauses[] = "division = ?";
  $params[] = $filter_division;
}
if ($filter_gender) {
  $where_clauses[] = "gender = ?";
  $params[] = $filter_gender;
}

$where_sql = count($where_clauses) > 0 ? "WHERE " . implode(" AND ", $where_clauses) : "";

$query = "SELECT id, name, gender, division, team_group, location, logo FROM teams $where_sql ORDER BY name ASC";
$stmt = $db->prepare($query);
$stmt->execute($params);
$teams_list = $stmt->fetchAll();

// Stats Summary
try {
  $total_teams = $db->query("SELECT COUNT(*) FROM teams")->fetchColumn();
  $male_teams = $db->query("SELECT COUNT(*) FROM teams WHERE gender='Men'")->fetchColumn();
  $female_teams = $db->query("SELECT COUNT(*) FROM teams WHERE gender='Women'")->fetchColumn();
} catch (PDOException $e) {
  $total_teams = $male_teams = $female_teams = 0;
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

  .filter-bar {
    background: #fff;
    padding: 16px 20px;
    border-radius: var(--radius-lg);
    border: 2px solid var(--gray-200);
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 16px;
    flex-wrap: wrap;
  }

  .filter-group {
    display: flex;
    align-items: center;
    gap: 10px;
  }

  .filter-group label {
    font-weight: 700;
    font-size: 13px;
    color: var(--gray-700);
    text-transform: uppercase;
  }

  .filter-control {
    padding: 8px 12px;
    border: 1px solid var(--gray-300);
    border-radius: 8px;
    font-size: 14px;
    min-width: 150px;
  }

  .stat-box {
    background: linear-gradient(135deg, #fff 0%, var(--gray-50) 100%);
    border: 2px solid var(--gray-200);
    border-radius: var(--radius-lg);
    padding: 20px;
    display: flex;
    align-items: center;
    gap: 16px;
    transition: all 0.3s ease;
  }
</style>

<div class="page-header">
  <div>
    <h1><i class="fas fa-users" style="color: var(--primary); margin-right: 12px;"></i>Teams Management</h1>
    <p>Manage basketball teams competing in the Rwanda Basketball League</p>
  </div>
  <div class="section-actions">
    <a href="dashboard" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Dashboard</a>
    <a href="team-form" class="btn btn-primary"><i class="fas fa-plus"></i> Add New Team</a>
  </div>
</div>

<?php if ($msg_flash): ?>
<div class="message <?php echo sanitize($_GET['type'] ?? 'message-success'); ?>" style="margin-bottom: 24px;">
  <i class="fas fa-check-circle"></i>
  <?php echo sanitize($msg_flash); ?>
</div>
<?php endif; ?>

<!-- Stats Summary -->
<div class="stats-summary">
  <div class="stat-box">
    <div class="stat-box-icon"
      style="background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);">
      <i class="fas fa-users"></i>
    </div>
    <div class="stat-box-content">
      <h4><?php echo $total_teams; ?></h4>
      <p>Total Teams</p>
    </div>
  </div>
  <div class="stat-box">
    <div class="stat-box-icon" style="background: linear-gradient(135deg, #3b82f6 0%, #1e40af 100%);">
      <i class="fas fa-mars"></i>
    </div>
    <div class="stat-box-content">
      <h4><?php echo $male_teams; ?></h4>
      <p>Men's Teams</p>
    </div>
  </div>
  <div class="stat-box">
    <div class="stat-box-icon" style="background: linear-gradient(135deg, #ec4899 0%, #be185d 100%);">
      <i class="fas fa-venus"></i>
    </div>
    <div class="stat-box-content">
      <h4><?php echo $female_teams; ?></h4>
      <p>Women's Teams</p>
    </div>
  </div>
</div>

<!-- Filter Bar -->
<div class="filter-bar">
  <form method="GET" style="display: flex; gap: 20px; width: 100%; flex-wrap: wrap; align-items: center;">
    <div class="filter-group">
      <label>Division:</label>
      <select name="division" class="filter-control" onchange="this.form.submit()">
        <option value="">All Divisions</option>
        <option value="Division 1" <?php echo $filter_division === 'Division 1' ? 'selected' : ''; ?>>Division 1</option>
        <option value="Division 2" <?php echo $filter_division === 'Division 2' ? 'selected' : ''; ?>>Division 2</option>
      </select>
    </div>
    <div class="filter-group">
      <label>Gender:</label>
      <select name="gender" class="filter-control" onchange="this.form.submit()">
        <option value="">All Genders</option>
        <option value="Men" <?php echo $filter_gender === 'Men' ? 'selected' : ''; ?>>Men</option>
        <option value="Women" <?php echo $filter_gender === 'Women' ? 'selected' : ''; ?>>Women</option>
      </select>
    </div>
    <?php if ($filter_division || $filter_gender): ?>
      <a href="teams" class="btn btn-secondary btn-sm" style="padding: 6px 12px; font-size: 12px;">Clear Filters</a>
    <?php endif; ?>
  </form>
</div>

<!-- Teams Table -->
<div class="admin-card">
  <div class="admin-card-header">
    <h3><i class="fas fa-list"></i>
      <?php echo ($filter_division || $filter_gender) ? 'Filtered Teams' : 'All Registered Teams'; ?></h3>
    <div style="display: flex; align-items: center; gap: 12px;">
      <span style="color: var(--gray-500); font-size: 14px; font-weight: 600;">
        <i class="fas fa-database"></i> <?php echo count($teams_list); ?> records
      </span>
    </div>
  </div>
  <div class="table-wrapper">
    <?php if (count($teams_list) > 0): ?>
      <table class="admin-table">
        <thead>
          <tr>
            <th><i class="fas fa-image"></i> Logo</th>
            <th><i class="fas fa-tag"></i> Team Name</th>
            <th><i class="fas fa-venus-mars"></i> Gender</th>
            <th><i class="fas fa-trophy"></i> Division</th>
            <th><i class="fas fa-map-marker-alt"></i> Location</th>
            <th style="text-align: center;"><i class="fas fa-cogs"></i> Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($teams_list as $t): ?>
            <tr>
              <td class="team-logo-cell">
                <?php if ($t['logo']): ?>
                  <img src="uploads/<?php echo sanitize($t['logo'] ?? ''); ?>"
                    alt="<?php echo sanitize($t['name'] ?? ''); ?> logo"
                    style="width: 48px; height: 48px; object-fit: cover; border-radius: 10px; border: 2px solid var(--gray-300); box-shadow: var(--shadow-sm);">
                <?php else: ?>
                  <div
                    style="width: 48px; height: 48px; background: linear-gradient(135deg, var(--gray-200) 0%, var(--gray-300) 100%); border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--gray-500); border: 2px solid var(--gray-300);">
                    <i class="fas fa-shield-alt"></i>
                  </div>
                <?php endif; ?>
              </td>
              <td class="team-name-cell"><?php echo sanitize($t['name'] ?? ''); ?></td>
              <td>
                <span class="gender-badge <?php echo $t['gender'] === 'Women' ? 'gender-female' : 'gender-male'; ?>">
                  <i class="fas fa-<?php echo $t['gender'] === 'Women' ? 'venus' : 'mars'; ?>"></i>
                  <?php echo sanitize($t['gender'] ?? ''); ?>
                </span>
              </td>
              <td>
                <div style="font-weight: 600; color: var(--gray-700);">
                  <?php echo sanitize($t['division'] ?? ''); ?>
                </div>
                <?php if ($t['division'] === 'Division 2' && !empty($t['team_group'])): ?>
                  <div style="font-size: 11px; color: var(--gray-500); margin-top: 4px; font-weight: 700;">
                    <i class="fas fa-layer-group"></i> <?php echo sanitize($t['team_group'] ?? ''); ?>
                  </div>
                <?php endif; ?>
              </td>
              <td>
                <span style="color: var(--gray-600); display: flex; align-items: center; gap: 6px;">
                  <i class="fas fa-map-pin" style="color: var(--danger);"></i>
                  <?php echo sanitize($t['location'] ?? ''); ?>
                </span>
              </td>
              <td>
                <div class="action-links" style="justify-content: center;">
                  <a href="team-form?id=<?php echo (int) $t['id']; ?>" class="action-link edit" data-tooltip="Edit Team">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <?php if (current_admin_role() === 'SuperAdmin'): ?>
                    <form method="POST" action="delete-team" style="display:inline; margin: 0; padding: 0;"
                      onsubmit="return confirm('Are you sure you want to delete this team? This action cannot be undone and may affect associated players and coaches.')">
                      <input type="hidden" name="csrf_token" value="<?php echo sanitize($csrf_token); ?>">
                      <input type="hidden" name="id" value="<?php echo (int) $t['id']; ?>">
                      <button type="submit" class="action-link delete" style="border:none; cursor:pointer; background:none; font-family: inherit;" data-tooltip="Delete Team">
                        <i class="fas fa-trash"></i> Delete
                      </button>
                    </form>
                  <?php endif; ?>
                </div>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    <?php else: ?>
      <div class="empty-state">
        <i class="fas fa-users-slash"></i>
        <h3>No Teams Found</h3>
        <p>Get started by adding your first basketball team to the system.</p>
        <a href="team-form" class="btn btn-primary" style="margin-top: 20px;">
          <i class="fas fa-plus"></i> Add First Team
        </a>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>