<?php require_once __DIR__ . '/includes/header.php'; ?><br><br><br><br><br><br>


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
    
    $all_teams = [];
    while($row = $res->fetch_assoc()) {
        $all_teams[] = $row;
    }
    $total_teams = count($all_teams);
    $teams_to_show = 8; // Show 8 teams initially (2 rows of 4)
    $show_view_more = $total_teams > $teams_to_show;

    $sectionClass = strtolower($gender) === 'men' ? 'men' : 'women';
    $sectionTitle = $gender === 'Men' ? '🏀 Men\'s Teams' : '🏀 Women\'s Teams';
    ?>

    <section class="team-section">
        <div class="section-title <?php echo $sectionClass; ?>">
            <h2><?php echo $sectionTitle; ?></h2>
        </div>

        <?php if ($total_teams === 0): ?>
            <div class="card">
                <div class="card-body">
                    <p style="padding:12px;color:#6b7280;text-align:center;">No teams found in this division.</p>
                </div>
            </div>
        <?php else: ?>
            <div class="teams-grid" id="teams-<?php echo strtolower($gender); ?>">
                <?php 
                $displayed = 0;
                foreach($all_teams as $t): 
                    if ($displayed >= $teams_to_show) break;
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
                <?php 
                    $displayed++;
                endforeach; ?>
            </div>
            
            <?php if ($show_view_more): ?>
                <div style="text-align:center;margin-top:20px;">
                    <button class="btn" onclick="showAllTeams('<?php echo strtolower($gender); ?>', <?php echo $total_teams; ?>, <?php echo json_encode($all_teams); ?>)">View More (<?php echo $total_teams - $teams_to_show; ?> more)</button>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </section>

<?php
}

// Render both sections
render_team_section($mysqli, 'Men', $division);
render_team_section($mysqli, 'Women', $division);

require_once __DIR__ . '/includes/footer.php';
?>
<script>
function showAllTeams(gender, totalTeams, allTeams) {
    const grid = document.getElementById('teams-' + gender);
    const button = event.target;
    
    // Clear existing teams
    grid.innerHTML = '';
    
    // Add all teams
    allTeams.forEach(function(t) {
        const teamLogo = t.logo ? 'admin/uploads/' + t.logo : 'https://via.placeholder.com/600x300?text=Team+Logo';
        const card = document.createElement('a');
        card.className = 'team-card';
        card.href = 'team.php?id=' + t.id;
        card.innerHTML = `
            <img src="${teamLogo}" alt="${t.name} Logo">
            <div class="card-overlay">
                <h3>${t.name}</h3>
                <p>${t.gender} • ${t.division} • ${t.location}</p>
            </div>
        `;
        grid.appendChild(card);
    });
    
    // Hide the button
    button.parentElement.style.display = 'none';
}

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
  });
});
</script>

