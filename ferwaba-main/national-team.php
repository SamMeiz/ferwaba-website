<?php
require_once __DIR__ . '/../includes/config.php';

$category = $_GET['category'] ?? null;
$teamParam = $_GET['team'] ?? null;

function escape($s)
{
    return htmlspecialchars($s, ENT_QUOTES, 'UTF-8');
}

$error = null;

// Ensure $mysqli is available
if (!isset($mysqli) || !($mysqli instanceof mysqli)) {
    error_log('[national-team] Missing $mysqli in includes/config.php');
    $error = 'Database error. Please try again later.';
} else {
    // load a specific team
    if ($teamParam) {
        $sql = "SELECT * FROM national_teams WHERE team_name = ? LIMIT 1";
        $stmt = $mysqli->prepare($sql);
        if ($stmt === false) {
            error_log('[national-team] prepare() failed: ' . $mysqli->error);
            $error = 'Database error. Please try again later.';
        } else {
            $stmt->bind_param('s', $teamParam);
            if (!$stmt->execute()) {
                error_log('[national-team] execute() failed: ' . $stmt->error);
                $error = 'Database error. Please try again later.';
            } else {
                $team = $stmt->get_result()->fetch_assoc();
            }
            $stmt->close();
        }

        if (empty($error) && !$team) {
            $error = 'No team found.';
        }

        if (empty($error) && $team) {
            $stmtP = $mysqli->prepare("SELECT * FROM national_players WHERE team_id=? ORDER BY jersey_number ASC");
            if ($stmtP === false) {
                error_log('[national-team] prepare(players) failed: ' . $mysqli->error);
                $players = new ArrayObject();
            } else {
                $stmtP->bind_param('i', $team['id']);
                $stmtP->execute();
                $players = $stmtP->get_result();
                $stmtP->close();
            }

            $stmtC = $mysqli->prepare("SELECT * FROM national_coaches WHERE team_id=? ORDER BY FIELD(role,'Head Coach','Assistant Coach','Team Staff'), name ASC");
            if ($stmtC === false) {
                error_log('[national-team] prepare(coaches) failed: ' . $mysqli->error);
                $coaches = new ArrayObject();
            } else {
                $stmtC->bind_param('i', $team['id']);
                $stmtC->execute();
                $coaches = $stmtC->get_result();
                $stmtC->close();
            }
        }
    }
    // load teams for a category
    elseif ($category) {
        $stmtT = $mysqli->prepare("SELECT id,team_name,banner_image,home_city,category FROM national_teams WHERE category = ? ORDER BY team_name ASC");
        if ($stmtT === false) {
            error_log('[national-team] prepare(teams) failed: ' . $mysqli->error);
            $error = 'Database error. Please try again later.';
        } else {
            $stmtT->bind_param('s', $category);
            if (!$stmtT->execute()) {
                error_log('[national-team] execute(teams) failed: ' . $stmtT->error);
                $error = 'Database error. Please try again later.';
            } else {
                $teams = $stmtT->get_result();
            }
            $stmtT->close();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>National Teams - Ferwaba</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --sea-green: #20B2AA;
            --sea-dark: #177f75;
            --muted: #6b7280;
            --card: #ffffff;
            --glass: rgba(255, 255, 255, 0.6)
        }

        * {
            box-sizing: border-box
        }

        body {
            font-family: Inter, system-ui, Arial, Helvetica, sans-serif;
            margin: 0;
            color: #111;
            background: #fff
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px
        }

        .header-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap
        }

        .category-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-top: 20px
        }

        .category-card {
            background: var(--card);
            padding: 22px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(23, 127, 117, 0.06);
            text-align: center;
            border: 1px solid rgba(23, 127, 117, 0.06);
            transition: transform .45s cubic-bezier(.2, .9, .2, 1), box-shadow .45s ease
        }

        .category-card h3 {
            margin: 8px 0;
            font-family: 'Playfair Display', serif;
            color: var(--sea-dark)
        }

        .category-card p {
            color: var(--muted)
        }

        .category-card .link-btn {
            background: linear-gradient(135deg, var(--sea-green), var(--sea-dark));
            border: 0;
            padding: 10px 14px;
            border-radius: 8px;
            color: #fff;
            font-weight: 700;
            display: inline-block;
            transition: transform .28s ease, box-shadow .28s ease
        }

        .category-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 28px 60px rgba(32, 178, 170, 0.12)
        }

        /* TEAM CARDS */
        .team-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 18px;
            margin-top: 18px
        }

        .team-card {
            background: var(--card);
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.06);
            box-shadow: 0 8px 28px rgba(0, 0, 0, 0.04);
            display: flex;
            flex-direction: column;
            transition: transform .45s cubic-bezier(.2, .9, .2, 1), box-shadow .45s ease, filter .45s ease;
            will-change: transform;
            cursor: default;
            position: relative;
            opacity: 0;
            transform-origin: center bottom
        }

        .team-card.visible {
            opacity: 1;
            transform: none
        }

        .team-card:hover {
            transform: translateY(-14px) scale(1.01);
            box-shadow: 0 30px 80px rgba(32, 178, 170, 0.12);
            filter: brightness(1.02)
        }

        .team-card:focus-within {
            outline: 3px solid rgba(32, 178, 170, 0.12)
        }

        .team-thumb {
            height: 140px;
            background: #0b0b0b;
            color: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            position: relative;
            overflow: hidden
        }

        .team-thumb::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 0%, rgba(0, 0, 0, 0.25) 70%);
            pointer-events: none
        }

        .team-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block
        }

        .team-body {
            padding: 14px;
            display: flex;
            flex-direction: column;
            gap: 6px;
            flex: 1
        }

        .team-body strong {
            font-family: 'Playfair Display', serif;
            font-size: 1.05rem
        }

        .small-meta {
            color: var(--muted);
            font-size: 0.9rem
        }

        .link-btn {
            display: inline-block;
            padding: 8px 12px;
            background: linear-gradient(135deg, var(--sea-green), var(--sea-dark));
            color: #fff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            transition: transform .28s ease, box-shadow .28s ease
        }

        .link-btn:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 36px rgba(32, 178, 170, 0.12)
        }

        /* subtle sheen on hover */
        .team-card::before {
            content: "";
            position: absolute;
            left: -60%;
            top: -30%;
            width: 40%;
            height: 160%;
            background: linear-gradient(120deg, transparent, rgba(255, 255, 255, 0.28), transparent);
            transform: skewX(-25deg);
            opacity: 0;
            transition: all .65s cubic-bezier(.2, .9, .2, 1)
        }

        .team-card:hover::before {
            left: 120%;
            opacity: 1;
            transition: all .65s cubic-bezier(.2, .9, .2, 1)
        }

        /* animated badges and labels */
        .team-card .badge {
            position: absolute;
            top: 12px;
            left: 12px;
            background: var(--sea-green);
            color: #fff;
            padding: 6px 10px;
            border-radius: 999px;
            font-weight: 700;
            font-size: 0.78rem;
            box-shadow: 0 8px 20px rgba(32, 178, 170, 0.12)
        }

        /* roster table tweaks */
        .table-responsive {
            width: 100%;
            overflow-x: auto
        }

        .roster-table {
            width: 100%;
            border-collapse: collapse
        }

        .roster-table th,
        .roster-table td {
            padding: 10px;
            border-bottom: 1px solid #f4f4f4;
            text-align: left
        }

        .muted {
            color: var(--muted)
        }

        /* entrance animation */
        @keyframes popIn {
            from {
                opacity: 0;
                transform: translateY(18px) scale(.995)
            }

            to {
                opacity: 1;
                transform: none
            }
        }

        .team-card.animate {
            animation: popIn .5s ease both
        }

        .team-card[data-delay] {
            animation-delay: var(--delay)
        }

        /* responsive */
        @media(max-width:720px) {
            .team-thumb {
                height: 110px
            }

            .category-grid {
                grid-template-columns: 1fr
            }

            .team-grid {
                grid-template-columns: repeat(auto-fit, minmax(160px, 1fr))
            }
        }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo"><a href="index"><img src="assets/images/logo.png" alt="Ferwaba Logo"
                        class="nav-logo-img"></a></div>
            <div class="nav-menu" id="nav-menu">
                <a href="index" class="nav-link">Home</a>
                <a href="about" class="nav-link">About</a>
                <a href="contact" class="nav-link">Contact</a>
                <a href="staff" class="nav-link">Staff</a>
                <a href="national-team" class="nav-link active">National Team</a>
                <a href="competitions" class="nav-link">Competitions</a>
            </div>
            <div class="nav-toggle" id="nav-toggle"><span class="bar"></span><span class="bar"></span><span
                    class="bar"></span></div>
        </div>
    </nav>
    <br><br><br><br><br>
    <div class="container">

        <?php if (isset($error)): ?>
            <p class="muted"><?php echo escape($error); ?></p>

        <?php elseif ($teamParam && $team): ?>
            <!-- TEAM DETAILS -->
            <a class="back-link" href="national-team?category=<?php echo urlencode($team['category']); ?>">&larr; Back to
                <?php echo escape($team['category']); ?></a>
            <?php if (!empty($team['banner_image'])): ?>
                <div style="width:100%;max-width:1200px;margin-bottom:18px;border-radius:10px;overflow:hidden">
                    <img src="admin/uploads/<?php echo escape($team['banner_image']); ?>"
                        alt="<?php echo escape($team['team_name']); ?>"
                        style="width:100%;height:180px;object-fit:cover;display:block">
                </div>
            <?php endif; ?>
            <h1 style="margin:6px 0 12px"><?php echo escape($team['team_name']); ?></h1>
            <p class="small-meta">Category: <?php echo escape($team['category']); ?> &nbsp;•&nbsp; Home:
                <?php echo escape($team['home_city'] ?? '—'); ?></p>

            <div style="display:grid;grid-template-columns:1fr 360px;gap:18px;margin-top:18px">
                <div class="card">
                    <h3 style="margin:0 0 12px">Roster</h3>
                    <?php if ($players->num_rows > 0): ?>
                        <div class="table-responsive">
                            <table class="roster-table">
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
                                    <?php while ($p = $players->fetch_assoc()):
                                        $photo = !empty($p['photo']) ? 'admin/uploads/' . $p['photo'] : 'https://via.placeholder.com/80x80?text=Player';
                                        ?>
                                        <tr>
                                            <td><img src="<?php echo escape($photo); ?>" alt=""
                                                    style="width:56px;height:56px;object-fit:cover;border-radius:50%"></td>
                                            <td><?php echo (int) $p['jersey_number']; ?></td>
                                            <td><a
                                                    href="player-card?id=<?php echo (int) $p['id']; ?>"><?php echo escape($p['name']); ?></a>
                                            </td>
                                            <td><?php echo escape($p['position']); ?></td>
                                            <td><?php echo escape($p['club']); ?></td>
                                        </tr>
                                    <?php endwhile; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <p class="muted">No players registered for this team.</p>
                    <?php endif; ?>
                </div>

                <aside class="card">
                    <h3 style="margin:0 0 12px">Coaches & Staff</h3>
                    <?php if ($coaches->num_rows > 0): ?>
                        <table class="roster-table">
                            <thead>
                                <tr>
                                    <th>Photo</th>
                                    <th>Name</th>
                                    <th>Role</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php while ($c = $coaches->fetch_assoc()):
                                    $cphoto = !empty($c['photo']) ? 'admin/uploads/' . $c['photo'] : 'https://via.placeholder.com/80x80?text=Coach';
                                    ?>
                                    <tr>
                                        <td><img src="<?php echo escape($cphoto); ?>" alt=""
                                                style="width:56px;height:56px;object-fit:cover;border-radius:50%"></td>
                                        <td><?php echo escape($c['name']); ?></td>
                                        <td><?php echo escape($c['role']); ?></td>
                                    </tr>
                                <?php endwhile; ?>
                            </tbody>
                        </table>
                    <?php else: ?>
                        <p class="muted">No coaches listed for this team.</p>
                    <?php endif; ?>
                </aside>
            </div>

        <?php elseif ($category && isset($teams)): ?>
            <!-- SHOW TEAMS IN SELECTED CATEGORY -->
            <a class="back-link" href="national-team">&larr; Back to Categories</a>
            <div class="header-row">
                <h1 style="margin:0"><?php echo escape($category); ?> Teams</h1>
                <p class="small-meta">Click a team to view roster and staff.</p>
            </div>

            <?php if ($teams->num_rows > 0): ?>
                <div class="team-grid">
                    <?php while ($t = $teams->fetch_assoc()):
                        $thumb = !empty($t['banner_image']) ? 'admin/uploads/' . $t['banner_image'] : '';
                        ?>
                        <div class="team-card">
                            <div class="team-thumb"
                                style="<?php echo $thumb ? "background-image:url('" . escape($thumb) . "');background-size:cover;background-position:center;color:transparent" : ''; ?>">
                                <?php if (!$thumb)
                                    echo strtoupper(substr($t['team_name'], 0, 2)); ?>
                            </div>
                            <div class="team-body">
                                <strong><?php echo escape($t['team_name']); ?></strong>
                                <div class="small-meta">Home: <?php echo escape($t['home_city'] ?? '—'); ?></div>
                                <div style="margin-top:8px"><a class="link-btn"
                                        href="national-team?team=<?php echo urlencode($t['team_name']); ?>">View Team</a></div>
                            </div>
                        </div>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="muted">No teams found for this category.</p>
            <?php endif; ?>

        <?php else: ?>
            <!-- CATEGORY SELECTION: add Senior, U18, U16, 3x3 (men & women) -->
            <div class="header-row">
                <div>
                    <h1 style="margin:0 0 6px">National Teams</h1>
                    <p class="small-meta">Choose a category to view participating teams.</p>
                </div>
            </div>

            <div class="category-grid" role="navigation" aria-label="Team categories">
                <div class="category-card">
                    <h3>Senior Men</h3>
                    <p class="small-meta">Rwanda senior men's national team and squads.</p>
                    <div style="margin-top:12px"><a class="link-btn" href="national-team?category=Senior%20Men">View
                            Teams</a></div>
                </div>
                <div class="category-card">
                    <h3>Senior Women</h3>
                    <p class="small-meta">Rwanda senior women's national team and squads.</p>
                    <div style="margin-top:12px"><a class="link-btn" href="national-team?category=Senior%20Women">View
                            Teams</a></div>
                </div>

                <div class="category-card">
                    <h3>U18 Men</h3>
                    <p class="small-meta">Under-18 men's national teams and development squads.</p>
                    <div style="margin-top:12px"><a class="link-btn" href="national-team?category=U18%20Men">View Teams</a>
                    </div>
                </div>
                <div class="category-card">
                    <h3>U18 Women</h3>
                    <p class="small-meta">Under-18 women's national teams and development squads.</p>
                    <div style="margin-top:12px"><a class="link-btn" href="national-team?category=U18%20Women">View
                            Teams</a></div>
                </div>

                <div class="category-card">
                    <h3>U16 Men</h3>
                    <p class="small-meta">Under-16 men's national development teams.</p>
                    <div style="margin-top:12px"><a class="link-btn" href="national-team?category=U16%20Men">View Teams</a>
                    </div>
                </div>
                <div class="category-card">
                    <h3>U16 Women</h3>
                    <p class="small-meta">Under-16 women's national development teams.</p>
                    <div style="margin-top:12px"><a class="link-btn" href="national-team?category=U16%20Women">View
                            Teams</a></div>
                </div>

                <div class="category-card">
                    <h3>3x3 Men</h3>
                    <p class="small-meta">3x3 men's national teams (Olympic format).</p>
                    <div style="margin-top:12px"><a class="link-btn" href="national-team?category=3x3%20Men">View Teams</a>
                    </div>
                </div>
                <div class="category-card">
                    <h3>3x3 Women</h3>
                    <p class="small-meta">3x3 women's national teams (Olympic format).</p>
                    <div style="margin-top:12px"><a class="link-btn" href="national-team?category=3x3%20Women">View
                            Teams</a></div>
                </div>
            </div>
        <?php endif; ?>

    </div><br><br><br><br>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">

                <!-- Ferwaba Intro Section -->
                <div class="footer-section">
                    <h3>Ferwaba</h3>
                    <p>Rwanda Basketball Federation dedicated to promoting and developing basketball excellence across
                        the nation.</p>
                    <div class="social-links">
                        <a href="https://www.instagram.com/ferwaba" target="_blank" class="social-link"><i
                                class="fab fa-instagram"></i></a>
                        <a href="https://www.facebook.com/ferwaba" target="_blank" class="social-link"><i
                                class="fab fa-facebook"></i></a>
                        <a href="https://www.twitter.com/ferwaba" target="_blank" class="social-link"><i
                                class="fab fa-twitter"></i></a>
                        <a href="https://www.youtube.com/@ferwaba" target="_blank" class="social-link"><i
                                class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="rbl">RBL</a></li>
                        <li><a href="gmc">GMC</a></li>
                        <li><a href="legacy">Legacy Cup</a></li>
                        <li><a href="teams">National Teams</a></li>
                        <li><a href="about">About</a></li>
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
                                width="100%" height="250" style="border:0;" allowfullscreen="" loading="lazy"
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
    <script>
        const navToggle = document.getElementById('nav-toggle');
        const navMenu = document.getElementById('nav-menu');
        if (navToggle) { navToggle.addEventListener('click', () => { navMenu.classList.toggle('active'); navToggle.classList.toggle('active'); }); }

        // Staggered reveal for team cards and accessible keyboard focus
        document.addEventListener('DOMContentLoaded', () => {
            const cards = Array.from(document.querySelectorAll('.team-card'));
            cards.forEach((c, i) => {
                // set CSS variable for stagger delay
                c.style.setProperty('--delay', (i * 80) + 'ms');
                // add animate class after small timeout so animation-delay applies
                setTimeout(() => c.classList.add('animate', 'visible'), 20 + i * 80);
                // add keyboard focus style target for accessibility
                const link = c.querySelector('.link-btn') || c.querySelector('a');
                if (link) {
                    link.addEventListener('focus', () => c.classList.add('visible'));
                    link.addEventListener('blur', () => {/* keep visible */ });
                }
            });
        });
    </script>
</body>

</html>