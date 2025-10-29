<?php require_once __DIR__ . '/includes/header.php'; ?>
<br><br><br><br>

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
            ORDER BY name ASC';

    $stmt = $mysqli->prepare($sql);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $res = $stmt->get_result();

    $sectionClass = strtolower($gender) === 'men' ? 'men' : 'women';
    $sectionTitle = $gender === 'Men' ? '🏀 Men’s Teams' : '🏀 Women’s Teams';
    ?>

    <section class="team-section">
        <div class="section-title <?php echo $sectionClass; ?>">
            <h2><?php echo $sectionTitle; ?></h2>
            <a href="teams.php?gender=<?php echo urlencode($gender); ?>&division=<?php echo urlencode($division); ?>" class="btn" style="background:#6b7280;">View More</a>
        </div>

        <div class="grid-col">
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
                <a class="team-card" href="team.php?id=<?php echo (int)$t['id']; ?>">
                    <img src="<?php echo $teamLogo; ?>" alt="<?php echo sanitize($t['name']); ?> Logo">
                    <div class="card-overlay">
                        <h3><?php echo sanitize($t['name']); ?></h3>
                        <p><?php echo sanitize($t['gender'].' • '.$t['division'].' • '.$t['location']); ?></p>
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
<script>
// Select all team cards
const teamCards = document.querySelectorAll('.team-card');

teamCards.forEach(card => {
  card.addEventListener('click', function(e){
    // Toggle 'active' class to show/hide overlay
    this.classList.toggle('active');

    // Optional: hide overlay if user clicks outside this card
    teamCards.forEach(otherCard => {
      if(otherCard !== this) otherCard.classList.remove('active');
    });

    // Prevent default link navigation if you want overlay first
    // e.preventDefault(); 
  });
});
</script>

