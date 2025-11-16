<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff - Ferwaba</title>
    <meta name="description" content="Meet the talented contemporary African artists featured at Inkingi Art Space. Discover their unique styles and artistic journeys.">
    <meta name="keywords" content="African artists, contemporary art, artist profiles, art gallery, creative talent">
    
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
                <a href="index.php">
                    <img src="assets/images/logo.png" alt="Ferwaba Logo" class="nav-logo-img" />
                </a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <a href="index.php" class="nav-link">Home</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="contact.php" class="nav-link">Contact</a>
                <a href="staff.php" class="nav-link active">Staff</a>
                <a href="national-team.php" class="nav-link highlight">National Team</a>
                <a href="competitions.php" class="nav-link">Competitions</a>
                
            </div>
            <div class="nav-toggle" id="nav-toggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav><br><br><br>

    <!-- Page Header -->
    <section class="page-header" style="padding: 40px 0; background-color: #f0f2f5; text-align:center;">
        <div class="container">
            <h1 style="font-size:36px; margin-bottom:10px;">Our Staff</h1>
            <p style="font-size:18px; color:#555;">Meet the team that drives FERWABA forward</p>
        </div>
    </section>

    <!-- Staff Grid -->
    <section class="staff-section" style="padding:50px 0;">
        <div class="container" style="display:flex; flex-wrap:wrap; justify-content:center; gap:40px;">
            
            <!-- Staff Card -->
            <div class="staff-card" style="flex:1 1 200px; max-width:220px; text-align:center;">
                <div style="width:150px; height:150px; margin:0 auto; overflow:hidden; border-radius:50%; border:3px solid #0077cc;">
                    <img src="assets/images/staff1.jpg" alt="John Doe" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <h3 style="margin-top:15px; font-size:20px; color:#1a1a1a;">John Doe</h3>
                <p style="color:#0077cc; font-weight:600; margin-top:5px;">President</p>
            </div>

            <div class="staff-card" style="flex:1 1 200px; max-width:220px; text-align:center;">
                <div style="width:150px; height:150px; margin:0 auto; overflow:hidden; border-radius:50%; border:3px solid #0077cc;">
                    <img src="assets/images/staff2.jpg" alt="Jane Smith" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <h3 style="margin-top:15px; font-size:20px; color:#1a1a1a;">Jane Smith</h3>
                <p style="color:#0077cc; font-weight:600; margin-top:5px;">Secretary General</p>
            </div>

            <div class="staff-card" style="flex:1 1 200px; max-width:220px; text-align:center;">
                <div style="width:150px; height:150px; margin:0 auto; overflow:hidden; border-radius:50%; border:3px solid #0077cc;">
                    <img src="assets/images/staff3.jpg" alt="Michael Johnson" style="width:100%; height:100%; object-fit:cover;">
                </div>
                <h3 style="margin-top:15px; font-size:20px; color:#1a1a1a;">Michael Johnson</h3>
                <p style="color:#0077cc; font-weight:600; margin-top:5px;">Head Coach</p>
            </div>

            <!-- Add more staff cards here -->
        </div>
    </section>

    <!-- Footer -->
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
                <!-- <div class="contact-info"> -->
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
    <script>
        // Artist filter functionality
        document.addEventListener('DOMContentLoaded', function() {
            const filterButtons = document.querySelectorAll('.filter-btn');
            const artistCards = document.querySelectorAll('.artist-card[data-medium]');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    const filter = this.getAttribute('data-filter');
                    
                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    // Filter artists
                    artistCards.forEach(card => {
                        if (filter === 'all' || card.getAttribute('data-medium') === filter) {
                            card.style.display = 'block';
                            card.classList.add('fade-in');
                        } else {
                            card.style.display = 'none';
                            card.classList.remove('fade-in');
                        }
                    });
                });
            });
        });
                // Mobile navigation toggle
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
