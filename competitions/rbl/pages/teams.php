<?php require_once __DIR__ . '/../includes/header.php'; ?><br><br>
<?php
// Initialize filters
$division_filter = $_GET['division'] ?? '';
$gender_filter = $_GET['gender'] ?? '';

// Build Query
$where = [];
$params = [];
$types = '';

if ($division_filter) {
  $where[] = "division = ?";
  $params[] = $division_filter;
  $types .= 's';
}
if ($gender_filter) {
  $where[] = "gender = ?";
  $params[] = $gender_filter;
  $types .= 's';
}

$where_clause = !empty($where) ? "WHERE " . implode(" AND ", $where) : "";
$sql = "SELECT * FROM teams $where_clause ORDER BY division ASC, name ASC";

$stmt = $mysqli->prepare($sql);
if (!empty($params)) {
  $stmt->bind_param($types, ...$params);
}
$stmt->execute();
$teams_res = $stmt->get_result();

$teams_by_div = [];
while ($t = $teams_res->fetch_assoc()) {
  $teams_by_div[$t['division']][] = $t;
}
?>

<style>
  .teams-page-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 20px;
    font-family: 'Inter', sans-serif;
  }

  /* Tightened Hero/Filters */
  .teams-hero {
    background: linear-gradient(135deg, #1a365d 0%, #0f172a 100%);
    border-radius: 16px;
    padding: 30px 20px;
    margin-bottom: 30px;
    text-align: center;
    color: #fff;
  }

  .teams-hero h1 {
    font-size: 28px;
    font-weight: 900;
    margin-bottom: 8px;
  }

  /* Filter Controls */
  .directory-filters {
    background: white;
    padding: 15px;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
    margin-bottom: 40px;
    display: flex;
    justify-content: center;
    gap: 12px;
    flex-wrap: wrap;
    border: 1px solid #eef2f6;
  }

  .directory-select {
    padding: 10px 15px;
    border-radius: 8px;
    border: 1px solid #e2e8f0;
    font-weight: 600;
    color: #4a5568;
    background: #f8fafc;
    min-width: 160px;
  }

  /* Division Sections */
  .division-section {
    margin-bottom: 60px;
  }

  .division-header {
    border-left: 5px solid #fbbf24;
    padding-left: 15px;
    margin-bottom: 25px;
  }

  .division-header h2 {
    font-size: 24px;
    font-weight: 800;
    color: #1a365d;
    margin: 0;
  }

  /* 🏀 ELITE COMPACT 4:3 CARDS */
  .teams-directory-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(160px, 1fr));
    gap: 15px;
  }

  .team-card-vertical {
    background: #fff;
    border-radius: 12px;
    overflow: hidden;
    text-decoration: none;
    color: inherit;
    border: 1px solid #eef2f6;
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
  }

  .team-card-vertical:hover {
    transform: translateY(-5px);
    border-color: #fbbf24;
    box-shadow: 0 8px 20px rgba(26, 54, 93, 0.1);
  }

  .logo-aspect-ratio {
    width: 100%;
    aspect-ratio: 4 / 3;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
    background: #f1f5f9;
    /* Subtle gray background to eliminate "empty" white feel */
  }

  .logo-aspect-ratio img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    /* Takes full space with no margins */
    transition: transform 0.5s ease;
  }

  .team-card-vertical:hover .logo-aspect-ratio img {
    transform: scale(1.1);
  }

  .card-content-compact {
    padding: 10px;
    text-align: center;
  }

  .team-name-v3 {
    font-size: 14px;
    font-weight: 800;
    color: #1a365d;
    margin: 0 0 3px 0;
    line-height: 1.2;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
  }

  .team-meta-v3 {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 5px;
    font-size: 9px;
    font-weight: 700;
    text-transform: uppercase;
    color: #fbbf24;
    letter-spacing: 0px;
  }

  .meta-gender-v3 {
    color: #fbbf24;
  }

  .meta-sep {
    color: #cbd5e1;
    font-weight: 400;
  }

  /* Mobile Adjustments */
  @media (max-width: 600px) {
    .teams-directory-grid {
      grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
      gap: 20px;
    }

    .card-content-compact {
      padding: 15px;
    }

    .team-name-v3 {
      font-size: 16px;
    }
  }
</style>

<div class="teams-page-container">

  <header class="teams-hero">
    <h1>Official RBL Teams</h1>
    <p style="opacity:0.8; font-size:14px;">The home of Rwandan Basketball Excellence</p>
  </header>

  <section class="directory-filters">
    <form method="get" style="display:contents;">
      <select name="division" class="directory-select" onchange="this.form.submit()">
        <option value="">All Divisions</option>
        <option value="Division 1" <?php echo $division_filter === 'Division 1' ? 'selected' : ''; ?>>Division 1</option>
        <option value="Division 2" <?php echo $division_filter === 'Division 2' ? 'selected' : ''; ?>>Division 2</option>
      </select>

      <select name="gender" class="directory-select" onchange="this.form.submit()">
        <option value="">All Genders</option>
        <option value="Men" <?php echo $gender_filter === 'Men' ? 'selected' : ''; ?>>Men</option>
        <option value="Women" <?php echo $gender_filter === 'Women' ? 'selected' : ''; ?>>Women</option>
      </select>
    </form>
  </section>

  <?php if (empty($teams_by_div)): ?>
    <p style="text-align:center; padding:100px; color:#64748b;">No teams found matching your filters.</p>
  <?php else: ?>
    <?php foreach ($teams_by_div as $div_name => $teams): ?>
      <section class="division-section">
        <div class="division-header">
          <h2><?php echo sanitize($div_name); ?></h2>
        </div>

        <div class="teams-directory-grid">
          <?php foreach ($teams as $t):
            $logo = !empty($t['logo']) ? '../../../admin/uploads/' . sanitize($t['logo']) : 'https://via.placeholder.com/400x300?text=Team+Logo';
            ?>
            <a href="team.php?id=<?php echo $t['id']; ?>" class="team-card-vertical">
              <div class="logo-aspect-ratio">
                <img src="<?php echo $logo; ?>" alt="<?php echo sanitize($t['name']); ?>">
              </div>
              <div class="card-content-compact">
                <h3 class="team-name-v3"><?php echo sanitize($t['name']); ?></h3>
                <div class="team-meta-v3">
                  <span class="meta-gender-v3"><?php echo sanitize($t['gender']); ?></span>
                  <span class="meta-sep">•</span>
                  <span><?php echo sanitize($t['division']); ?></span>
                </div>
              </div>
            </a>
          <?php endforeach; ?>
        </div>
      </section>
    <?php endforeach; ?>
  <?php endif; ?>

</div>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
