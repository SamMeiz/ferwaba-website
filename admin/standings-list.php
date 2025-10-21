<?php 
require_once __DIR__ . '/../includes/config.php';
require_login();
?>

<head>
  <link rel="stylesheet" href="../css/style.css">
  <style>
    .top-team { background-color: rgba(34,197,94,0.15); }
    .bottom-team { background-color: rgba(220,38,38,0.15); }
    .filter-bar {
      display: flex;
      gap: 16px;
      margin-bottom: 12px;
      align-items: center;
    }
    .gender-tabs {
      display: flex;
      gap: 8px;
    }
    .gender-tab {
      padding: 6px 12px;
      border-radius: 8px;
      border: 1px solid #d1d5db;
      cursor: pointer;
      background: #f3f4f6;
    }
    .gender-tab.active {
      background: #2563eb;
      color: #fff;
      border-color: #2563eb;
    }
    select {
      padding: 6px;
      border-radius: 8px;
      border: 1px solid #d1d5db;
    }
  </style>
</head>

<div class="filter-bar">
  <div class="gender-tabs">
    <div class="gender-tab active" data-gender="Men">Men</div>
    <div class="gender-tab" data-gender="Women">Women</div>
  </div>
  <select id="divisionSelect">
    <option value="Division 1">Division 1</option>
    <option value="Division 2">Division 2</option>
  </select>
  <a href="standings-form.php" class="btn">➕ Add Team Standing</a>
  <a href="javascript:history.back()" class="btn" style="background:#6b7280;margin-left:8px;">⬅️ Back</a>

</div>

<div class="card">
  <table id="standingsTable">
    <thead>
      <tr>
        <th>Team</th>
        <th>Division</th>
        <th>Gender</th>
        <th>GP</th>
        <th>W</th>
        <th>L</th>
        <th>Pts</th>
        <th>Win%</th>
        <th>GB</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $res = $mysqli->query("
        SELECT s.*, t.name 
        FROM standings s 
        JOIN teams t ON t.id = s.team_id 
        ORDER BY s.gender, s.division, s.points DESC, s.wins DESC, t.name ASC
      ");

      $grouped = [];
      while($row = $res->fetch_assoc()) {
          $key = $row['division'].'_'.$row['gender'];
          $grouped[$key][] = $row;
      }

      foreach($grouped as $group):
          $leader = $group[0];
          $leader_wins = $leader['wins'];
          $leader_losses = $leader['losses'];
          $count = count($group);

          foreach($group as $index => $row):
              $gp = max(1, (int)$row['games_played']);
              $win_pct = round(((int)$row['wins'] / $gp) * 100, 2);
              $gb = round((($leader_wins - (int)$row['wins']) + ((int)$row['losses'] - $leader_losses)) / 2, 2);
              $row_class = '';
              if ($index < 3) $row_class = 'top-team';
              elseif ($index >= $count - 3) $row_class = 'bottom-team';
      ?>
      <tr class="standing-row <?php echo $row_class; ?>"
          data-gender="<?php echo sanitize($row['gender']); ?>"
          data-division="<?php echo sanitize($row['division']); ?>">
        <td><?php echo sanitize($row['name']); ?></td>
        <td><?php echo sanitize($row['division']); ?></td>
        <td><?php echo sanitize($row['gender']); ?></td>
        <td><?php echo (int)$row['games_played']; ?></td>
        <td><?php echo (int)$row['wins']; ?></td>
        <td><?php echo (int)$row['losses']; ?></td>
        <td><?php echo (int)$row['points']; ?></td>
        <td><?php echo number_format($win_pct, 2); ?></td>
        <td><?php echo number_format($gb, 2); ?></td>
        <td>
          <a href="standings-form.php?id=<?php echo (int)$row['id']; ?>" class="btn-small">✏️ Edit</a>
          <a href="delete-standings.php?id=<?php echo (int)$row['id']; ?>" 
             class="btn-small danger" 
             onclick="return confirm('Delete this record?')">🗑️ Delete</a>
        </td>
      </tr>
      <?php endforeach; endforeach; ?>
    </tbody>
  </table>
</div>

<script>
  const tabs = document.querySelectorAll('.gender-tab');
  const divisionSelect = document.getElementById('divisionSelect');
  const rows = document.querySelectorAll('.standing-row');
  let currentGender = 'Men';

  function filterTable() {
    const selectedDivision = divisionSelect.value;
    rows.forEach(row => {
      const gender = row.dataset.gender;
      const division = row.dataset.division;
      if (gender === currentGender && division === selectedDivision) {
        row.style.display = '';
      } else {
        row.style.display = 'none';
      }
    });
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
