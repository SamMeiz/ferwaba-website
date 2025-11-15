
<?php require_once __DIR__ . '/../includes/config.php'; ?><br><br><br><br>
<?php
$teamParam = $_GET['team'] ?? 'Senior Men';

// Fetch team info from database
$stmt = $mysqli->prepare("SELECT * FROM national_teams WHERE category=? LIMIT 1");
$stmt->bind_param('s', $teamParam);
$stmt->execute();
$team = $stmt->get_result()->fetch_assoc();

if (!$team) {
    echo "<p>No team found for this category.</p>";
    exit;
}

// Fetch players for this team
$stmtP = $mysqli->prepare("SELECT * FROM national_players WHERE team_id=? ORDER BY jersey_number ASC");
$stmtP->bind_param('i', $team['id']);
$stmtP->execute();
$players = $stmtP->get_result();

// Fetch coaches for this team
$stmtC = $mysqli->prepare("SELECT * FROM national_coaches WHERE team_id=? ORDER BY FIELD(role,'Head Coach','Assistant Coach','Team Staff'), name ASC");
$stmtC->bind_param('i', $team['id']);
$stmtC->execute();
$coaches = $stmtC->get_result();
?>
<br><br>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>National Teams - Ferwaba</title>
    <meta name="description" content="Get in touch with Inkingi Art Space. Visit our gallery, inquire about artworks, or learn about our programs and events.">
    <meta name="keywords" content="contact, art gallery, visit, inquiries, Inkingi Art Space, location, hours">
    
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
     <style>
        /* Inkingi Art Space - Blue/White/Dark Green Theme */

/* Team Filter Buttons */
nav.muted a { display:inline-block; padding:8px 16px; border-radius:8px; text-decoration:none; font-weight:500; border:1px solid #ccc; background:#f3f4f6; color:#111; transition:all 0.2s ease; }
nav.muted a:hover { background:#1E7F1E; color:white; border-color:#1E7F1E; }

/* Sections */
.section-title { text-align:center; margin:80px 0 40px; }
.section-title img { width:100%; max-width:1600px; border-radius:12px; object-fit:cover; }

/* Grid Layout */
.grid { display:grid; grid-template-columns:repeat(auto-fit,minmax(300px,1fr)); gap:2rem; margin-bottom:3rem; }

/* Cards */
.card { background:#ffffff; border-radius:12px; padding:1.5rem; box-shadow:0 2px 10px rgba(0,0,0,0.1); transition:all 0.3s ease; }
.card:hover { transform:translateY(-5px); box-shadow:0 4px 20px rgba(0,0,0,0.15); }

/* Tables */
.table-wrapper { overflow-x:auto; }
table { width:100%; border-collapse:collapse; margin-top:1rem; }
table th, table td { padding:12px 15px; text-align:left; border-bottom:1px solid #e9ecef; }
table th { background:#003366; color:white; font-weight:600; }
table tr:hover { background:#f3f4f6; }
table a { color:#003366; text-decoration:none; font-weight:500; }
table a:hover { color:#1E7F1E; }

/* Player/Coach Images */
table img { width:60px; height:60px; object-fit:cover; border-radius:50%; }

/* Buttons */
.btn { display:inline-block; padding:12px 24px; border-radius:12px; font-weight:500; text-decoration:none; text-align:center; cursor:pointer; transition:all 0.3s ease; }
.btn-primary { background:#1E7F1E; color:white; border:none; }
.btn-primary:hover { background:#003366; color:white; transform:translateY(-2px); }



/* Team Filter Buttons Container */
nav.muted {
    display: flex;
    flex-wrap: wrap; /* wrap buttons to next line if too many */
    gap: 10px;
    margin-bottom: 20px;
    justify-content: center; /* center-align the buttons */
}

/* Individual Filter Buttons */
nav.muted a {
    display: inline-block;
    padding: 8px 16px;
    background: #f3f4f6;
    color: #111;
    font-weight: 500;
    border-radius: 8px;
    border: 1px solid #ccc;
    text-decoration: none;
    text-align: center;
    transition: all 0.2s ease;
    white-space: nowrap; /* prevent text wrap inside button */
}
nav.muted a:hover {
    background: #1E7F1E;
    color: white;
    border-color: #1E7F1E;
}

/* Table Scroll */
.table-wrapper {
    overflow-x: auto; /* horizontal scroll if table is wider than container */
    width: 100%;
}

/* Optional: add some spacing/padding around tables */
.table-wrapper table {
    min-width: 600px; /* ensures scroll appears on smaller screens */
    border-collapse: collapse;
}


/* Responsive */
@media (max-width:768px) {
    .grid { grid-template-columns:1fr; }
    .nav-menu { position:fixed; left:-100%; top:70px; flex-direction:column; width:100%; background:#003366; padding:2rem 0; text-align:center; transition:0.3s; }
    .nav-menu.active { left:0; }
    .nav-toggle { display:flex; flex-direction:column; cursor:pointer; }
    .nav-toggle.active .bar:nth-child(2) { opacity:0; }
    .nav-toggle.active .bar:nth-child(1) { transform:translateY(8px) rotate(45deg); }
    .nav-toggle.active .bar:nth-child(3) { transform:translateY(-8px) rotate(-45deg); }
    table th, table td { padding:10px; }
}

@media (max-width:480px) {
    .container { padding:0 15px; }
}

     </style>
</head>
   <!-- Navigation -->
   <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="index.php">
                    <h1>Ferwaba</h1>
                </a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <a href="index.php" class="nav-link">Home</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="contact.php" class="nav-link">Contact</a>
                <a href="staff.php" class="nav-link">Staff</a>
                <a href="national-team.php" class="nav-link active highlight">National Team</a>
                <a href="competitions.php" class="nav-link">Competitions</a>
                
            </div>
            <div class="nav-toggle" id="nav-toggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>
<nav class="muted" style="display:flex;gap:10px;flex-wrap:wrap;margin-bottom:20px;">
    <?php 
    $opts=['Senior Men','Senior Women','U18 Men','U18 Women','U16 Men','U16 Women']; 
    foreach($opts as $o): ?>
        <a 
            href="<?php echo asset_url('national-team.php?team='.urlencode($o)); ?>" 
            style="
                display:inline-block;
                padding:8px 16px;
                background:#f3f4f6;
                color:#111;
                font-weight:500;
                border-radius:8px;
                border:1px solid #ccc;
                text-decoration:none;
                transition:all 0.2s ease;
            "
            onmouseover="this.style.background='#007bff'; this.style.color='#fff'; borderColor='#007bff';"
            onmouseout="this.style.background='#f3f4f6'; this.style.color='#111'; borderColor='#ccc';"
        >
            <?php echo $o; ?>
        </a>
    <?php endforeach; ?>
</nav>


<section class="section-title" style="text-align:center; width:100%;">
    <?php if (!empty($team['banner_image'])): ?>
        <div style="width:100%; max-width:1600px; aspect-ratio:4/1; overflow:hidden; margin:0 auto; border-radius:12px;">
            <img src="admin/uploads/<?php echo sanitize($team['banner_image']); ?>" 
                 alt="<?php echo sanitize($team['team_name']); ?> Banner"
                 style="width:100%; height:100%; object-fit:cover; object-position:center;">
        </div>
    <?php endif; ?>
</section>

<div class="grid col-2">

    <!-- ROSTER -->
    <div class="card">
        <div class="table-wrapper">
            <h3>Roster</h3>
            <?php if ($players->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>#</th>
                        <th>Name</th>
                        <th>Position</th>
                        <th>Club</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($p = $players->fetch_assoc()): 
                        $photo = !empty($p['photo']) ? '/../admin/uploads/'.$p['photo'] : 'https://via.placeholder.com/80x80?text=Player';
                    ?>
                    <tr>
                        <td><img src="<?php echo $photo; ?>" alt="Player Photo" style="width:60px;height:60px;object-fit:cover;border-radius:50%;"></td>
                        <td><?php echo (int)$p['jersey_number']; ?></td>
                        <td><a href="player-card.php?id=<?php echo $p['id']; ?>"><?php echo sanitize($p['name']); ?></a></td>
                        <td><?php echo sanitize($p['position']); ?></td>
                        <td><?php echo sanitize($p['club']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="muted">No players for this team.</div>
            <?php endif; ?>
        </div>
    </div>

    <!-- COACHES -->
    <div class="card">
        <div class="table-wrapper">
            <h3>Coaches</h3>
            <?php if ($coaches->num_rows > 0): ?>
            <table>
                <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while($c = $coaches->fetch_assoc()): 
                        $cphoto = !empty($c['photo']) ? '/../admin/uploads/'.$c['photo'] : 'https://via.placeholder.com/80x80?text=Coach';
                    ?>
                    <tr>
                        <td><img src="<?php echo $cphoto; ?>" alt="Coach Photo" style="width:60px;height:60px;object-fit:cover;border-radius:50%;"></td>
                        <td><?php echo sanitize($c['name']); ?></td>
                        <td><?php echo sanitize($c['role']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
            <?php else: ?>
                <div class="muted">No coaches for this team.</div>
            <?php endif; ?>
        </div>
    </div>

</div>
<!-- FOOTER -->
<footer class="footer">
    <div class="container">
        <div class="footer-content">

            <!-- Ferwaba Intro Section -->
            <div class="footer-section">
                <h3>Ferwaba</h3>
                <p>Rwanda Basketball Federation dedicated to promoting and developing basketball excellence across the nation.</p>
                <div class="social-links">
                    <a href="https://www.instagram.com/ferwaba" target="_blank" class="social-link"><i class="fab fa-instagram"></i></a>
                    <a href="https://www.facebook.com/ferwaba" target="_blank" class="social-link"><i class="fab fa-facebook"></i></a>
                    <a href="https://www.twitter.com/ferwaba" target="_blank" class="social-link"><i class="fab fa-twitter"></i></a>
                    <a href="https://www.youtube.com/@ferwaba" target="_blank" class="social-link"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="rbl.php">RBL</a></li>
                    <li><a href="gmc.php">GMC</a></li>
                    <li><a href="legacy.php">Legacy Cup</a></li>
                    <li><a href="teams.php">National Teams</a></li>
                    <li><a href="about.php">About</a></li>
                </ul>
            </div>

            <!-- Contact Info -->
            <div class="footer-section">
                <h4>Contact Info</h4>
                    <p><i class="fas fa-map-marker-alt"></i> KG 17 Ave, Kigali</p>
                    <p><i class="fas fa-phone"></i> (+250) 791586243</p>
                    <p><i class="fas fa-envelope"></i> info@ferwaba.rw</p>
            </div>

            <!-- Google Maps -->
            <div class="footer-section">
                <h4>Visit Us</h4>

                <div class="map-wrapper" style="
                    display:flex;
                    justify-content:center;
                    align-items:center;
                    width:100%;
                    margin:auto;
                ">
                    <div class="map-container" style="
                        width:100%;
                        max-width:600px;
                        border-radius:12px;
                        overflow:hidden;
                        margin:auto;
                    ">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3987.5289447897!2d30.11545!3d-1.95308!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca700506d750d%3A0xc2003608f4f76438!2sFERWABA!5e0!3m2!1sen!2srw!4v1731610000000!5m2!1sen!2srw"
                            width="100%"
                            height="250"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>

        </div>

        <!-- Footer Bottom -->
        <div class="footer-bottom">
            <p>&copy; 2025 Ferwaba - Rwanda Basketball Federation. All rights reserved.</p>
        </div>
    </div>
</footer>

    <script src="assets/js/main.js"></script>
</body>
</html>


