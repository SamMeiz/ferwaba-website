<?php
$page_title = 'Standings Management';
require_once __DIR__ . '/includes/admin-header.php';
?>

<style>
  .standings-filters {
    background: #fff;
    border-radius: var(--radius-lg);
    padding: 24px;
    margin-bottom: 28px;
    box-shadow: var(--shadow);
    border: 2px solid var(--gray-200);
    display: flex;
    gap: 20px;
    align-items: center;
    flex-wrap: wrap;
  }

  .gender-tabs {
    display: flex;
    gap: 10px;
    background: var(--gray-100);
    padding: 4px;
    border-radius: var(--radius-md);
  }

  .gender-tab {
    padding: 10px 24px;
    border-radius: var(--radius);
    cursor: pointer;
    background: transparent;
    color: var(--gray-700);
    font-weight: 600;
    font-size: 14px;
    transition: var(--transition);
    border: 2px solid transparent;
  }

  .gender-tab:hover {
    background: var(--gray-200);
  }

  .gender-tab.active {
    background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
    color: #fff;
    box-shadow: var(--shadow-md);
  }

  .division-select {
    padding: 12px 18px;
    border-radius: var(--radius-md);
    border: 2px solid var(--gray-300);
    font-size: 14px;
    font-weight: 600;
    background: var(--gray-50);
    color: var(--gray-800);
    cursor: pointer;
    transition: var(--transition);
  }

  .division-select:focus {
    outline: none;
    border-color: var(--primary);
    background: #fff;
    box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.1);
  }

  .top-team {
    background: linear-gradient(135deg, rgba(0, 166, 81, 0.08) 0%, rgba(0, 166, 81, 0.05) 100%);
    border-left: 4px solid var(--secondary) !important;
  }

  .bottom-team {
    background: linear-gradient(135deg, rgba(196, 30, 58, 0.08) 0%, rgba(196, 30, 58, 0.05) 100%);
    border-left: 4px solid var(--danger) !important;
  }

  .standing-row {
    border-left: 4px solid transparent;
  }

  .rank-badge {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    width: 32px;
    height: 32px;
    border-radius: 50%;
    background: linear-gradient(135deg, var(--gray-200) 0%, var(--gray-300) 100%);
    color: var(--gray-800);
    font-weight: 700;
    font-size: 14px;
  }

  .top-team .rank-badge {
    background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-dark) 100%);
    color: #fff;
  }
</style>

<div class="page-header">
  <div>
    <h1>Standings Management</h1>
    <p>View and manage league standings by division and gender</p>
  </div>
  <div class="section-actions">
    <a href="dashboard.php" class="btn btn-secondary"><i class="fas fa-arrow-left"></i> Back</a>
    <a href="standings-form.php" class="btn btn-primary"><i class="fas fa-plus"></i> Add Standing</a>
  </div>
</div>

<div class="standings-filters">
  <div style="display: flex; align-items: center; gap: 12px;">
    <i class="fas fa-venus-mars" style="font-size: 20px; color: var(--primary);"></i>
    <div class="gender-tabs">
      <div class="gender-tab active" data-gender="Men">
        <i class="fas fa-mars"></i> Men
      </div>
      <div class="gender-tab" data-gender="Women">
        <i class="fas fa-venus"></i> Women
      </div>
    </div>
  </div>

  <div style="display: flex; align-items: center; gap: 12px;">
    <i class="fas fa-trophy" style="font-size: 20px; color: var(--accent);"></i>
    <select id="divisionSelect" class="division-select">
      <option value="Division 1">Division 1</option>
      <option value="Division 2">Division 2</option>
    </select>
  </div>
</div>

<div class="admin-card">
  <div class="admin-card-header">
    <h3><i class="fas fa-list-ol"></i> League Standings</h3>
    <span style="color: var(--gray-500); font-size: 14px;" id="teamCount">Loading...</span>
  </div>
  <div class="table-wrapper">
    <table class="admin-table">
      <thead>
        <tr>
          <th><i class="fas fa-hashtag"></i> Rank</th>
          <th><i class="fas fa-users"></i> Team</th>
          <th><i class="fas fa-trophy"></i> Division</th>
          <th><i class="fas fa-layer-group"></i> Group</th>
          <th><i class="fas fa-venus-mars"></i> Gender</th>
          <th><i class="fas fa-gamepad"></i> GP</th>
          <th><i class="fas fa-check-circle"></i> W</th>
          <th><i class="fas fa-times-circle"></i> L</th>
          <th><i class="fas fa-star"></i> Pts</th>
          <th><i class="fas fa-percent"></i> Win%</th>
          <th><i class="fas fa-chart-line"></i> GB</th>
          <th><i class="fas fa-cogs"></i> Actions</th>
        </tr>
      </thead>
      <tbody id="standingsBody">
        <?php
        $res = $mysqli->query("
          SELECT s.*, t.name 
          FROM standings s 
          JOIN teams t ON t.id = s.team_id 
          ORDER BY s.gender, s.division, s.points DESC, s.wins DESC, t.name ASC
        ");

        $grouped = [];
        while ($row = $res->fetch_assoc()) {
          $key = $row['division'] . '_' . $row['gender'];
          $grouped[$key][] = $row;
        }

        foreach ($grouped as $group):
          $leader = $group[0];
          $leader_wins = $leader['wins'];
          $leader_losses = $leader['losses'];
          $count = count($group);

          foreach ($group as $index => $row):
            $rank = $index + 1;
            $gp = max(1, (int) $row['games_played']);
            $win_pct = round(((int) $row['wins'] / $gp) * 100, 2);
            $gb = round((($leader_wins - (int) $row['wins']) + ((int) $row['losses'] - $leader_losses)) / 2, 2);
            $row_class = '';
            if ($index < 3)
              $row_class = 'top-team';
            elseif ($index >= $count - 3)
              $row_class = 'bottom-team';
            ?>
            <tr class="standing-row <?php echo $row_class; ?>" data-gender="<?php echo sanitize($row['gender']); ?>"
              data-division="<?php echo sanitize($row['division']); ?>">
              <td>
                <span class="rank-badge"><?php echo $rank; ?></span>
              </td>
              <td><strong><?php echo sanitize($row['name'] ?? ''); ?></strong></td>
              <td><?php echo sanitize($row['division'] ?? ''); ?></td>
              <td>
                <?php if (!empty($row['team_group'])): ?>
                  <span class="status-badge" style="background: var(--blue-100); color: var(--blue-700); font-size: 11px;">
                    <?php echo sanitize($row['team_group']); ?>
                  </span>
                <?php else: ?>
                  <span style="color: var(--gray-400);">—</span>
                <?php endif; ?>
              </td>
              <td>
                <span class="status-badge" style="background: var(--gray-100); color: var(--gray-700);">
                  <i class="fas fa-<?php echo ($row['gender'] ?? 'Men') === 'Women' ? 'venus' : 'mars'; ?>"></i>
                  <?php echo sanitize($row['gender'] ?? 'Men'); ?>
                </span>
              </td>
              <td><?php echo (int) $row['games_played']; ?></td>
              <td><strong style="color: var(--secondary);"><?php echo (int) $row['wins']; ?></strong></td>
              <td><strong style="color: var(--danger);"><?php echo (int) $row['losses']; ?></strong></td>
              <td><strong style="color: var(--primary);"><?php echo (int) $row['points']; ?></strong></td>
              <td><?php echo number_format($win_pct, 1); ?>%</td>
              <td><?php echo $gb == 0 ? '—' : number_format($gb, 1); ?></td>
              <td>
                <div class="action-links">
                  <a href="standings-form.php?id=<?php echo (int) $row['id']; ?>" class="action-link edit">
                    <i class="fas fa-edit"></i> Edit
                  </a>
                  <a href="delete-standings.php?id=<?php echo (int) $row['id']; ?>" class="action-link delete"
                    onclick="return confirm('Delete this standing record?')">
                    <i class="fas fa-trash"></i> Delete
                  </a>
                </div>
              </td>
            </tr>
          <?php endforeach; endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<script>
  const tabs = document.querySelectorAll('.gender-tab');
  const divisionSelect = document.getElementById('divisionSelect');
  const rows = document.querySelectorAll('.standing-row');
  const teamCount = document.getElementById('teamCount');
  let currentGender = 'Men';

  function filterTable() {
    const selectedDivision = divisionSelect.value;
    let visibleCount = 0;

    rows.forEach(row => {
      const gender = row.dataset.gender;
      const division = row.dataset.division;
      if (gender === currentGender && division === selectedDivision) {
        row.style.display = '';
        visibleCount++;
      } else {
        row.style.display = 'none';
      }
    });

    teamCount.textContent = `${visibleCount} team${visibleCount !== 1 ? 's' : ''}`;
  }

  tabs.forEach(tab => {
    tab.addEventListener('click', () => {
      tabs.forEach(t => t.classList.remove('active'));
      tab.classList.add('active');
      currentGender = tab.dataset.gender;
      filterTable();
    });
  });

  divisionSelect.addEventListener('change', filterTable);
  filterTable(); // initial filter
</script>

<?php require_once __DIR__ . '/includes/admin-footer.php'; ?>