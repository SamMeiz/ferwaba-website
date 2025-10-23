<?php require_once __DIR__ . '/includes/header.php'; ?>

<section class="section-title">
  <h2>All Teams</h2>

  <!-- Auto filter form -->
  <form method="get" class="grid col-1" style="max-width:260px;">
    <select name="division" onchange="this.form.submit()" style="padding:8px;border-radius:8px;border:1px solid #e5e7eb;">
      <option value="">All Divisions</option>
      <option value="Division 1" <?php echo (($_GET['division'] ?? '')==='Division 1')?'selected':''; ?>>Division 1</option>
      <option value="Division 2" <?php echo (($_GET['division'] ?? '')==='Division 2')?'selected':''; ?>>Division 2</option>
    </select>
  </form>
</section>

<?php
$division = $_GET['division'] ?? '';

// Function to render one section
function render_team_section($mysqli, $gender, $division) {
  $where = ['gender=?'];
  $params = [$gender];
  $types = 's';

  if ($division) {
    $where[] = 'division=?';
    $params[] = $division;
    $types .= 's';
  }

  $sql = 'SELECT id, name, location, logo, gender, division 
          FROM teams 
          WHERE ' . implode(' AND ', $where) . ' 
          ORDER BY name ASC 
          LIMIT 9';

  $stmt = $mysqli->prepare($sql);
  $stmt->bind_param($types, ...$params);
  $stmt->execute();
  $res = $stmt->get_result();
  ?>

  <section style="margin-top:24px;">
    <div class="section-title"
         style="display:flex;justify-content:space-between;align-items:center;
                background:<?php echo $gender==='Men' ? '#e0f2fe' : '#fce7f3'; ?>;
                padding:8px 12px;border-radius:8px;">
      <h2 style="margin:0;"><?php echo $gender==='Men' ? '🏀 Men’s Teams' : '🏀 Women’s Teams'; ?></h2>
      <a href="teams.php?gender=<?php echo urlencode($gender); ?>&division=<?php echo urlencode($division); ?>" class="btn" style="background:#6b7280;">View More</a>
    </div>

    <div class="grid col-3">
      <?php 
      if ($res->num_rows === 0): ?>
        <p style="padding:12px;color:#6b7280;">No teams found in this division.</p>
      <?php 
      else:
        while($t = $res->fetch_assoc()): 
          $teamLogo = !empty($t['logo']) 
              ? 'admin/uploads/' . sanitize($t['logo']) 
              : 'https://via.placeholder.com/600x300?text=Team+Logo';
      ?>
        <a class="card" href="team.php?id=<?php echo (int)$t['id']; ?>">
          <img src="<?php echo $teamLogo; ?>" 
               alt="<?php echo sanitize($t['name']); ?> Logo"
               style="width:100%;height:160px;object-fit:cover;border-bottom:2px solid #eee">
          <div class="card-body">
            <h3><?php echo sanitize($t['name']); ?></h3>
            <div class="muted"><?php echo sanitize($t['gender'].' • '.$t['division'].' • '.$t['location']); ?></div>
          </div>
        </a>
      <?php endwhile; endif; ?>
    </div>
  </section>
  <?php
}

// Render both sections
render_team_section($mysqli, 'Men', $division);
render_team_section($mysqli, 'Women', $division);

require_once __DIR__ . '/includes/footer.php';
?>
