<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Competitions - Ferwaba</title>
    <meta name="description"
        content="Support Inkingi Art Space in promoting contemporary African art and supporting emerging artists. Make a donation today.">
    <meta name="keywords" content="donate, support art, African art, art gallery, cultural support, art funding">

    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Support Our Mission - Inkingi Art Space">
    <meta property="og:description"
        content="Support Inkingi Art Space in promoting contemporary African art and supporting emerging artists.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://inkingiartspace.com/donations.php">

    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --blue: #0a9b3aff;
            --gold: #FFD700;
            --dark-blue: #8fa70aff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            color: #333;
        }

        /* Section Styles */
        .section {
            padding: 60px 5%;
            max-width: 1400px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            margin-bottom: 60px;
        }

        .section-title h2 {
            font-family: 'Playfair Display', serif;
            font-size: 2.5rem;
            margin: 0 0 15px;
            color: var(--blue);
        }

        .section-title p {
            color: #666;
            font-size: 1.1rem;
            max-width: 600px;
            margin: 0 auto;
        }

        /* League Card - Single Centered */
        .league-container {
            display: flex;
            justify-content: center;
            margin-bottom: 40px;
        }

        .league-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid #e9ecef;
            max-width: 450px;
            width: 100%;
        }

        .league-card:hover {
            transform: translateY(-15px);
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
        }

        .league-logo {
            height: 280px;
            background: linear-gradient(135deg, var(--blue) 0%, var(--dark-blue) 100%);
            font-size: 7rem;
            color: white;
            position: relative;
        }

        .league-info {
            padding: 35px;
            text-align: center;
        }

        .league-info h3 {
            margin: 0 0 15px;
            color: #212529;
            font-size: 2rem;
            font-family: 'Playfair Display', serif;
        }

        .league-info p {
            color: #6c757d;
            margin: 0 0 25px;
            font-size: 1.05rem;
            line-height: 1.7;
        }

        .league-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 2px solid #e9ecef;
        }

        .stat {
            text-align: center;
        }

        .stat-value {
            font-size: 2rem;
            font-weight: 700;
            color: var(--blue);
        }

        .stat-label {
            font-size: 0.85rem;
            color: #6c757d;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 5px;
        }

        /* Cups Grid */
        .cups-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 35px;
            margin-bottom: 60px;
        }

        .cup-card {
            background: white;
            border-radius: 16px;
            overflow: hidden;
            transition: all 0.4s ease;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            border: 1px solid #e9ecef;
        }

        .cup-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12);
        }

        .cup-logo {
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 5.5rem;
            color: white;
            position: relative;
        }

        .cup-info {
            padding: 28px;
            text-align: center;
        }

        .cup-info h3 {
            margin: 0 0 12px;
            color: #212529;
            font-size: 1.5rem;
            font-family: 'Playfair Display', serif;
        }

        .cup-info p {
            color: #6c757d;
            margin: 0 0 20px;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        .cup-stats {
            display: flex;
            justify-content: space-around;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .cup-stats .stat-value {
            font-size: 1.5rem;
        }

        .cup-stats .stat-label {
            font-size: 0.8rem;
        }

        /* Button Styles */
        .btn {
            display: inline-block;
            padding: 12px 32px;
            background: var(--blue);
            color: white;
            text-decoration: none;
            border-radius: 8px;
            font-weight: 600;
            transition: all 0.3s;
            border: 2px solid var(--blue);
        }

        .btn:hover {
            background: var(--dark-blue);
            border-color: var(--dark-blue);
            transform: scale(1.05);
        }

        .btn-outline {
            background: transparent;
            color: var(--blue);
        }

        .btn-outline:hover {
            background: var(--blue);
            color: white;
        }
    </style>
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar">
        <div class="nav-container">
            <div class="nav-logo">
                <a href="index">
                    <img src="assets/images/logo.png" alt="Ferwaba Logo" class="nav-logo-img" />
                </a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <a href="index" class="nav-link">Home</a>
                <a href="about" class="nav-link">About</a>
                <a href="contact" class="nav-link">Contact</a>
                <a href="staff" class="nav-link">Staff</a>
                <a href="national-team" class="nav-link highlight">National Team</a>
                <a href="competitions" class="nav-link active">Competitions</a>

            </div>
            <div class="nav-toggle" id="nav-toggle">
                <span class="bar"></span>
                <span class="bar"></span>
                <span class="bar"></span>
            </div>
        </div>
    </nav><br><br>

    <!-- Main Content -->
    <main class="site-main">
        <!-- League Section -->
        <section class="section" style="padding-top: 120px;">
            <div class="section-title">
                <h2>League</h2>
                <p>Rwanda's premier professional basketball competition</p>
            </div>

            <style>
                /* Reduce the league logo height for this page */
                .league-container .league-logo {
                    height: 180px !important;
                }
            </style>
            <div class="league-container">
                <div class="league-card">
                    <div class="league-logo">
                        <img src="assets/images/Rbl.jpg" alt="Rwanda Basketball League"
                            style="width: 100%; height: 100%; object-fit: cover;">
                    </div>
                    <div class="league-info">
                        <h3>Rwanda Basketball League</h3>
                        <p>The premier professional basketball league in Rwanda featuring top teams from across the
                            country competing at the highest level.</p>
                        <a href="../competitions/rbl/pages/index" class="btn">View RBL</a>
                        <div class="league-stats">
                            <div class="stat">
                                <div class="stat-value">2</div>
                                <div class="stat-label">Divisions</div>
                            </div>
                            <div class="stat">
                                <div class="stat-value">12</div>
                                <div class="stat-label">Teams</div>
                            </div>
                            <div class="stat">
                                <div class="stat-value">156</div>
                                <div class="stat-label">Games</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Cups Section -->
        <section class="section" style="background-color: #f8f9fa;">
            <div class="section-title">
                <h2>Cup Tournaments</h2>
                <p>Prestigious knockout competitions celebrating basketball excellence</p>
            </div>

            <div class="cups-grid">
                <!-- Genocide Memorial Cup -->
                <div class="cup-card">
                    <div class="cup-logo" style="background: linear-gradient(135deg, #DC143C 0%, #8B0000 100%);">
                        <img src="assets/images/gmc.jpg" alt="Genocide Memorial Cup"
                            style="width:100%; height:100%; object-fit:cover; display:block;">
                    </div>
                    <div class="cup-info">
                        <h3>Genocide Memorial Cup</h3>
                        <p>Honoring the memory of victims while celebrating basketball excellence.</p>
                        <a href="../competitions/gmc" class="btn">View GMC</a>
                        <div class="cup-stats">
                            <div class="stat">
                                <div class="stat-value">16</div>
                                <div class="stat-label">Teams</div>
                            </div>
                            <div class="stat">
                                <div class="stat-value">48</div>
                                <div class="stat-label">Games</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Heroes Cup -->
                <div class="cup-card">
                    <div class="cup-logo" style="background: linear-gradient(135deg, #DC143C 0%, #8B0000 100%);">
                        <img src="assets/images/hero.jpg" alt="Genocide Memorial Cup"
                            style="width:100%; height:100%; object-fit:cover; display:block;">
                    </div>
                    <div class="cup-info">
                        <h3>Heroes Cup</h3>
                        <p>Elite knockout tournament featuring Rwanda's finest teams.</p>
                        <a href="../competitions/heroes" class="btn">View Heroes Cup</a>
                        <div class="cup-stats">
                            <div class="stat">
                                <div class="stat-value">8</div>
                                <div class="stat-label">Teams</div>
                            </div>
                            <div class="stat">
                                <div class="stat-value">15</div>
                                <div class="stat-label">Games</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Legacy Cup -->
                <div class="cup-card">
                    <div class="cup-logo" style="background: linear-gradient(135deg, #DC143C 0%, #8B0000 100%);">
                        <img src="assets/images/gmc.jpg" alt="Genocide Memorial Cup"
                            style="width:100%; height:100%; object-fit:cover; display:block;">
                    </div>
                    <div class="cup-info">
                        <h3>Legacy Cup</h3>
                        <p>Celebrating the rich history and legacy of Rwandan basketball.</p>
                        <a href="../competitions/legacy" class="btn">View Details</a>
                        <div class="cup-stats">
                            <div class="stat">
                                <div class="stat-value">12</div>
                                <div class="stat-label">Teams</div>
                            </div>
                            <div class="stat">
                                <div class="stat-value">30</div>
                                <div class="stat-label">Games</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Rwanda Cup -->
                <div class="cup-card">
                    <div class="cup-logo" style="background: linear-gradient(135deg, #DC143C 0%, #8B0000 100%);">
                        <img src="assets/images/RC.jpg" alt="Genocide Memorial Cup"
                            style="width:100%; height:100%; object-fit:cover; display:block;">
                    </div>
                    <div class="cup-info">
                        <h3>Rwanda Cup</h3>
                        <p>The national championship determining Rwanda's supreme champions.</p>
                        <a href="../competitions/rwanda-cup" class="btn">View Details</a>
                        <div class="cup-stats">
                            <div class="stat">
                                <div class="stat-value">16</div>
                                <div class="stat-label">Teams</div>
                            </div>
                            <div class="stat">
                                <div class="stat-value">32</div>
                                <div class="stat-label">Games</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Super Cup -->
                <div class="cup-card">
                    <div class="cup-logo" style="background: linear-gradient(135deg, #DC143C 0%, #8B0000 100%);">
                        <img src="assets/images/SPC.jpg" alt="Genocide Memorial Cup"
                            style="width:100%; height:100%; object-fit:cover; display:block;">
                    </div>
                    <div class="cup-info">
                        <h3>Super Cup</h3>
                        <p>Season opener between league and cup champions.</p>
                        <a href="../competitions/supercup" class="btn">View Super Cup</a>
                        <div class="cup-stats">
                            <div class="stat">
                                <div class="stat-value">2</div>
                                <div class="stat-label">Teams</div>
                            </div>
                            <div class="stat">
                                <div class="stat-value">1</div>
                                <div class="stat-label">Game</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="footer-content">

                    <!-- Ferwaba Intro Section -->
                    <div class="footer-section">
                        <h3>Ferwaba</h3>
                        <p>Rwanda Basketball Federation dedicated to promoting and developing basketball excellence
                            across the nation.</p>
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