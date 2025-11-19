<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferwaba News - Official Updates</title>
    <meta name="description" content="Official FERWABA news, announcements, match updates, and features.">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
   <!-- Navigation -->
   <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="index.php" class="nav-brand">
                    <img src="assets/images/logo.png" alt="Ferwaba Logo" class="nav-logo-img" />
                </a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <a href="index.php" class="nav-link">Home</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="contact.php" class="nav-link">Contact</a>
                <a href="staff.php" class="nav-link">Staff</a>
                <a href="national-team.php" class="nav-link highlight">National Team</a>
                <a href="competitions.php" class="nav-link">Competitions</a>
            </div>
            <div class="nav-toggle" id="nav-toggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav>

    <!-- Page Hero -->
    <section class="page-hero" style="padding:60px 0;background:#0f172a;color:#fff;">
        <div class="container">
            <h1 style="font-family:'Playfair Display',serif;font-weight:700;margin:0;">FERWABA News</h1>
            <p style="margin-top:8px;color:#cbd5e1;">Official updates, announcements, and stories from FERWABA.</p>
        </div>
    </section

<section class="section-header" style="padding:24px 0;">
  <div class="container">
    <div class="section-header">
      <h2>Latest News</h2>
      <p>Stay up to date with FERWABA.</p>
    </div>
    <div class="news-categories" style="display:flex;gap:12px;flex-wrap:wrap;margin-top:12px;">
      <span class="badge" style="background:#f3f4f6;padding:8px 12px;border-radius:999px;">All</span>
      <span class="badge" style="background:#f3f4f6;padding:8px 12px;border-radius:999px;">Announcements</span>
      <span class="badge" style="background:#f3f4f6;padding:8px 12px;border-radius:999px;">Matches</span>
      <span class="badge" style="background:#f3f4f6;padding:8px 12px;border-radius:999px;">Programs</span>
      <span class="badge" style="background:#f3f4f6;padding:8px 12px;border-radius:999px;">Community</span>
    </div>
  </div>
</section>

    <!-- News Grid -->
    <section class="news-section">
        <div class="container">
            <div class="news-grid">
                <div class="news-card">
                    <div class="news-image">
                        <img src="assets/images/Ferwaba.jpg" alt="Federation Update">
                    </div>
                    <div class="news-details">
                        <span class="news-meta">Nov 2025 · Announcement</span>
                        <h3>Federation Update: Season Planning</h3>
                        <p>Key timelines and milestones for the upcoming basketball season have been announced.</p>
                        <a href="#" class="news-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <div class="news-image">
                        <img src="assets/images/Rbl.jpg" alt="Fixture Release">
                    </div>
                    <div class="news-details">
                        <span class="news-meta">Nov 2025 · Matches</span>
                        <h3>Fixture Release: Upcoming Matches</h3>
                        <p>Check the latest fixtures and mark your calendars for the biggest games.</p>
                        <a href="#" class="news-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <div class="news-image">
                        <img src="assets/images/comp.jpg" alt="Grassroots Program">
                    </div>
                    <div class="news-details">
                        <span class="news-meta">Nov 2025 · Programs</span>
                        <h3>Grassroots Program Expansion</h3>
                        <p>FERWABA expands its youth development programs across districts to nurture talent.</p>
                        <a href="#" class="news-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <div class="news-image">
                        <img src="assets/images/SPC.jpg" alt="SuperCup Press Briefing">
                    </div>
                    <div class="news-details">
                        <span class="news-meta">Nov 2025 · Community</span>
                        <h3>SuperCup Press Briefing</h3>
                        <p>Highlights from the SuperCup briefing and key notes from federation officials.</p>
                        <a href="#" class="news-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <style>
            .news-section { padding: 60px 0; background: #f8f9fa; }
            .news-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 20px; }
            .news-card { background: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0,0,0,.08); transition: transform .3s ease, box-shadow .3s ease; }
            .news-card:hover { transform: translateY(-4px); box-shadow: 0 12px 20px rgba(0,0,0,.12); }
            .news-image { width: 100%; height: 220px; overflow: hidden; }
            .news-image img { width: 100%; height: 100%; object-fit: cover; }
            .news-details { padding: 20px; }
            .news-meta { font-size: .85rem; color: #64748b; text-transform: uppercase; letter-spacing: .5px; }
            .news-details h3 { margin: 10px 0; font-size: 1.25rem; color: #0f172a; }
            .news-details p { color: #334155; margin: 8px 0 16px; }
            .news-link { display: inline-flex; align-items: center; gap: 8px; color: #ff6b35; font-weight: 600; text-decoration: none; }
            .news-link:hover { gap: 12px; }
            @media (max-width: 768px) { .news-grid { grid-template-columns: 1fr; } }
        </style>
    </section

    <!-- Footer -->
    <footer class="footer">
    <div class="container">
        <div class="footer-content">

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

            <div class="footer-section">
                <h4>Quick Links</h4>
                <ul>
                    <li><a href="competitions.php">Competitions</a></li>
                    <li><a href="teams.php">Teams</a></li>
                    <li><a href="national-team.php">National Team</a></li>
                    <li><a href="about.php">About</a></li>
                    <li><a href="contact.php">Contact</a></li>
                </ul>
            </div>

            <div class="footer-section">
                <h4>Contact Info</h4>
                    <p><i class="fas fa-map-marker-alt"></i> KG 17 Ave, Kigali</p>
                    <p><i class="fas fa-phone"></i> (+250) 791586243</p>
                    <p><i class="fas fa-envelope"></i> info@ferwaba.rw</p>
            </div>
        </div>

        <div class="footer-bottom">
            <p>&copy; 2025 Ferwaba - Rwanda Basketball Federation. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
  const navToggle = document.getElementById('nav-toggle');
  const navMenu = document.getElementById('nav-menu');
  if (navToggle) {
      navToggle.addEventListener('click', () => {
          navMenu.classList.toggle('active');
          navToggle.classList.toggle('active');
      });
  }
</script>
</body>
</html>
