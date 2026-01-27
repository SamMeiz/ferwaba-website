﻿<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ferwaba - Rwanda Basketball Federation</title>
    <meta name="description" content="Ferwaba is the official basketball federation in Rwanda, organizing premier competitions including RBL, GMC, and Legacy Cup.">
    <meta name="keywords" content="Ferwaba, Rwanda basketball, RBL, Genocide Memorial Cup, Legacy Cup, basketball federation">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Ferwaba - Rwanda Basketball Federation">
    <meta property="og:description" content="Official basketball federation organizing premier competitions in Rwanda.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://ferwaba.rw">
    <meta property="og:image" content="https://ferwaba.rw/assets/images/og-image.jpg">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "SportsOrganization",
        "name": "Ferwaba",
        "description": "Rwanda Basketball Federation",
        "url": "https://ferwaba.rw",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "KG 17 Ave, Kigali",
            "addressLocality": "Kigali",
            "addressRegion": "Kigali",
            "postalCode": "00000",
            "addressCountry": "RW"
        },
        "telephone": "+250791586243",
        "email": "info@ferwaba.rw"
    }
    </script>
    
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
                <a href="index.php" class="nav-link active">Home</a>
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

    <!-- Hero Carousel -->
    <section class="hero">
    <div class="hero-wrapper">
        <!-- Left Side - Image Carousel -->
        <div class="hero-left">
            <div class="hero-carousel">
                <div class="hero-slide active">
                    <div class="hero-image" style="background-image: url('assets/images/comp.jpg')"></div>
                </div>
                <div class="hero-slide">
                    <div class="hero-image" style="background-image: url('assets/images/Rbl.jpg')"></div>
                </div>
                <div class="hero-slide">
                    <div class="hero-image" style="background-image: url('assets/images/Ferwaba.jpg')"></div>
                </div>
            </div>
            
            <!-- Image Controls -->
            <div class="hero-controls">
                <button class="hero-prev" onclick="changeSlide(-1)">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="hero-next" onclick="changeSlide(1)">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
            
            <!-- Indicators -->
            <div class="hero-indicators">
                <span class="indicator active" onclick="currentSlideFunc(1)"></span>
                <span class="indicator" onclick="currentSlideFunc(2)"></span>
                <span class="indicator" onclick="currentSlideFunc(3)"></span>
            </div>
        </div>
        
        <!-- Right Side - Content -->
        <div class="hero-right">
            <div class="hero-content-wrapper">
                <div class="hero-content active" data-slide="1">
                    <h2 class="hero-title">Rwanda Basketball Excellence</h2>
                    <p class="hero-subtitle">Experience the thrill of professional basketball in Rwanda</p>
                    <a href="competitions.php" class="btn btn-primary">Check out Competitions</a>
                </div>
                
                <div class="hero-content" data-slide="2">
                    <h2 class="hero-title">Rwanda Basketball League</h2>
                    <p class="hero-subtitle">Watch the best teams compete for the championship</p>
                    <a href="../competitions/rbl/pages/index.php" class="btn btn-primary">View RBL</a>
                </div>
                
                <div class="hero-content" data-slide="3">
                    <h2 class="hero-title">Join the Ferwaba Family</h2>
                    <p class="hero-subtitle">Support Rwanda's basketball community</p>
                    <a href="#support" class="btn btn-primary">Follow Us</a>
                </div>
            </div>
        </div>
    </div>
</section>


    <!-- Competitions -->
    <section class="featured-artworks">
        <div class="container">
            <div class="section-header">
                <h2>Competitions</h2>
                <p>Discover our curated selection of exceptional ferwaba competitions</p>
            </div>
            <div class="artworks-grid">
                <div class="artwork-card">
                    <div class="artwork-image">
                        <img src="assets/images/SPC.jpg" alt="Ferwaba SuperCup">
                        <div class="artwork-overlay">
                            <a href="../competitions/supercup.php" class="btn btn-outline">View SuperCup</a>
                        </div>
                    </div>
                    <div class="artwork-info">
                       <a href="../competitions/supercup.php" style="text-decoration: none; color: inherit;"><h3>Ferwaba SuperCup</h3></a> 
                    </div>
                </div>
                <div class="artwork-card">
                    <div class="artwork-image">
                        <img src="assets/images/Gmc.jpg" alt="Genocide Memorial Cup">
                        <div class="artwork-overlay">
                            <a href="../competitions/gmc.php" class="btn btn-outline">View GMC</a>
                        </div>
                    </div>
                    <div class="artwork-info">
                    <a href="../competitions/gmc.php" style="text-decoration: none; color: inherit;"><h3>Genocide Memorial Cup(GMC)</h3></a> 
                    </div>
                </div>
                <div class="artwork-card">
                    <div class="artwork-image">
                        <img src="assets/images/RC.jpg" alt="rwanda cup">
                        <div class="artwork-overlay">
                            <a href="../competitions/rwanda-cup.php" class="btn btn-outline">View Details</a>
                        </div>
                    </div>
                    <div class="artwork-info">
                       <a href="../competitions/rwanda-cup.php" style="text-decoration: none; color: inherit;"><h3>Rwanda Cup</h3"></a>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="competitions.php" class="btn btn-secondary">View All Competitions</a>
            </div>
        </div>
    </section>

    <!-- Impact Counters -->
    <section class="impact-counters">
        <div class="container">
            <div class="counters-grid">
                <div class="counter-item">
                    <div class="counter-number" data-target="250+">0</div>
                    <div class="counter-label">Games Played</div>
                </div>
                <div class="counter-item">
                    <div class="counter-number" data-target="25+">0</div>
                    <div class="counter-label">Teams</div>
                </div>
                <div class="counter-item">
                    <div class="counter-number" data-target="15+">0</div>
                    <div class="counter-label">Competitions Hosted</div>
                </div>
                <div class="counter-item">
                    <div class="counter-number" data-target="150000">0</div>
                    <div class="counter-label">Fans Engaged</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="upcoming-events">
        <div class="container">
            <div class="section-header">
                <h2>Upcoming Events</h2>
                <p>Don't miss out on exciting basketball action</p>
            </div>
            <div class="events-grid">
                <div class="event-card">
                    <div class="event-date">
                        <span class="day">15</span>
                        <span class="month">DEC</span>
                    </div>
                    <div class="event-content">
                        <h3>RBL Finals Game 1</h3>
                        <p class="event-time">6:00 PM - 9:00 PM</p>
                        <p class="event-description">The championship series begins with top teams battling for the title.</p>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-date">
                        <span class="day">22</span>
                        <span class="month">DEC</span>
                    </div>
                    <div class="event-content">
                        <h3>Youth Basketball Clinic</h3>
                        <p class="event-time">2:00 PM - 5:00 PM</p>
                        <p class="event-description">Professional players mentor young athletes in skills development.</p>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-date">
                        <span class="day">30</span>
                        <span class="month">DEC</span>
                    </div>
                    <div class="event-content">
                        <h3>All-Star Game 2024</h3>
                        <p class="event-time">7:00 PM - 10:00 PM</p>
                        <p class="event-description">The best players showcase their talents in this annual celebration.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- News Section -->
    <section class="news-section">
        <div class="container">
            <div class="section-header">
                <h2>Latest News</h2>
                <p>Updates from our ferwaba community</p>
            </div>
            <div class="news-grid">
                <div class="news-card">
                    <div class="news-image">
                        <img src="assets/images/ferwa.jpg" alt="RBL Season Highlights">
                    </div>
                    <div class="news-details">
                        <span class="news-meta">Nov 2025 · Ferwaba</span>
                        <h3> Ferwaba new Executive Director.</h3>
                        <p>The Rwanda Basketball Federation (FERWABA) has appointed François-Régis Gahuranyi as its new Executive Director.
                           Gahuranyi, who previously served as Executive Director of the Rwanda Cycling Federation (FERWACY), replaces Fionah Ishimwe, who held the position for the past three years.</p>
                        <a href="#" class="news-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <div class="news-image">
                        <img src="assets/images/nat.jpg" alt="National Team Camp">
                    </div>
                    <div class="news-details">
                        <span class="news-meta">Nov 2025 · National Team</span>
                        <h3>National Team Camp</h3>
                        <p>The 2027 FIBA World Cup qualifiers will be played across six windows between November 2025 and March 2027, with a total of 420 games worldwide. The African windows are scheduled for November 2025, February 2026, and July 2026.</p>
                        <a href="#" class="news-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
                <div class="news-card">
                    <div class="news-image">
                        <img src="assets/images/apr.jpg" alt="Youth Development Program">
                    </div>
                    <div class="news-details">
                        <span class="news-meta">Nov 2025 · Fiba Wcc</span>
                        <h3>APR crowned WBLA Zone 5 Champions</h3>
                        <p>APR secured their first Women's Basketball League Africa (WBLA) Zone 5 title, defeating rivals Rwanda Energy Group (REG) 82-71 in an entertaining final on in Nairobi, Kenya, on Saturday.</p>
                        <a href="#" class="news-link">Read More <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
        </div>
        <style>
         .news-section { padding: 80px 0; background-color: #f8f9fa; }
         .news-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 30px; margin-top: 40px; }
         .news-card { background: white; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1); transition: transform 0.3s ease, box-shadow 0.3s ease; }
         .news-card:hover { transform: translateY(-5px); box-shadow: 0 8px 15px rgba(0, 0, 0, 0.15); }
         .news-image { width: 100%; height: 220px; overflow: hidden; }
         .news-image img { width: 100%; height: 100%; object-fit: cover; transition: transform 0.3s ease; }
         .news-card:hover .news-image img { transform: scale(1.1); }
         .news-details { padding: 24px; }
         .news-meta { display: inline-block; font-size: 0.85rem; color: #666; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 12px; }
         .news-details h3 { margin: 12px 0; font-size: 1.4rem; font-weight: 600; color: #1a1a1a; line-height: 1.4; }
         .news-details p { margin: 12px 0 20px; font-size: 1rem; color: #555; line-height: 1.6; }
         .news-link { display: inline-flex; align-items: center; gap: 8px; color: #ff6b35; font-weight: 600; text-decoration: none; transition: gap 0.3s ease; }
         .news-link:hover { gap: 12px; }
         .news-link i { font-size: 0.9rem; }
        @media (max-width: 768px) { .news-grid { grid-template-columns: 1fr; } }
        </style>
    </section>

    <!-- Support CTA -->
    <section class="donation-cta" id="support">
        <div class="container">
            <div class="cta-content">
                <h2>Support Us</h2>
                <p>Support us by subscribing and following our social media pages</p>
                <div class="social-links" style="display: flex; justify-content: center; gap: 30px; margin: 40px 0; font-size: 3em;">
                    <a href="https://www.instagram.com/ferwaba" target="_blank" class="social-link" style="color: #E1306C; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-instagram"></i>
                    </a>
                    <a href="https://www.youtube.com/@ferwaba" target="_blank" class="social-link" style="color: #FF0000; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-youtube"></i>
                    </a>
                    <a href="https://www.facebook.com/ferwaba" target="_blank" class="social-link" style="color: #1877F2; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-facebook"></i>
                    </a>
                    <a href="https://www.twitter.com/ferwaba" target="_blank" class="social-link" style="color: #1DA1F2; transition: transform 0.3s;" onmouseover="this.style.transform='scale(1.2)'" onmouseout="this.style.transform='scale(1)'">
                        <i class="fab fa-twitter"></i>
                    </a>
                </div>
            </div>
        </div>
    </section><br><br><br>

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
        // Hero carousel functionality
        let heroCurrentSlide = 1;
let heroSlideInterval;

function changeSlide(n) {
    showHeroSlide(heroCurrentSlide += n);
}

function currentSlideFunc(n) {
    showHeroSlide(heroCurrentSlide = n);
}

function showHeroSlide(n) {
    const slides = document.querySelectorAll('.hero-slide');
    const indicators = document.querySelectorAll('.hero-indicators .indicator');
    const contents = document.querySelectorAll('.hero-content');
    
    if (n > slides.length) { heroCurrentSlide = 1 }
    if (n < 1) { heroCurrentSlide = slides.length }
    
    // Remove active classes
    slides.forEach(slide => slide.classList.remove('active'));
    indicators.forEach(indicator => indicator.classList.remove('active'));
    contents.forEach(content => content.classList.remove('active'));
    
    // Add active classes
    slides[heroCurrentSlide - 1].classList.add('active');
    indicators[heroCurrentSlide - 1].classList.add('active');
    contents[heroCurrentSlide - 1].classList.add('active');
    
    // Reset interval
    clearInterval(heroSlideInterval);
    startHeroSlideshow();
}

function startHeroSlideshow() {
    heroSlideInterval = setInterval(() => {
        changeSlide(1);
    }, 5000); // Change slide every 5 seconds
}

// Auto-start slideshow when page loads
document.addEventListener('DOMContentLoaded', function() {
    startHeroSlideshow();
});
        // Counter animation
        function animateCounters() {
            const counters = document.querySelectorAll('.counter-number');
            counters.forEach(counter => {
                const target = parseInt(counter.getAttribute('data-target'));
                const increment = target / 100;
                let current = 0;
                
                const timer = setInterval(() => {
                    current += increment;
                    if (current >= target) {
                        current = target;
                        clearInterval(timer);
                    }
                    counter.textContent = Math.floor(current).toLocaleString();
                }, 20);
            });
        }

        // Trigger counter animation when section is visible
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounters();
                    observer.unobserve(entry.target);
                }
            });
        });

        const impactSection = document.querySelector('.impact-counters');
        if (impactSection) {
            observer.observe(impactSection);
        }


        let currentReviewSet = 0;
        
        function rotateReviews() {
            const reviewCards = document.querySelectorAll('.review-card');
            
            reviewCards.forEach((card, index) => {
                const reviewIndex = (currentReviewSet * 3 + index) % reviews.length;
                const review = reviews[reviewIndex];
                
                card.querySelector('.review-text').textContent = review.text;
                card.querySelector('.review-author strong').textContent = review.author;
                card.querySelector('.review-author span').textContent = review.role;
            });
            
            currentReviewSet = (currentReviewSet + 1) % Math.ceil(reviews.length / 3);
        }

        // Auto-rotate reviews every 3 seconds
        setInterval(rotateReviews, 3000);

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