<!DOCTYPE html>
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
                    <a href="/ferwaba1/index.php" class="btn btn-primary">View RBL</a>
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
                            <a href="/ferwaba1/Cups/supercup.php" class="btn btn-outline">View SuperCup</a>
                        </div>
                    </div>
                    <div class="artwork-info">
                       <a href="/ferwaba1/Cups/supercup.php" style="text-decoration: none; color: inherit;"><h3>Ferwaba SuperCup</h3></a> 
                    </div>
                </div>
                <div class="artwork-card">
                    <div class="artwork-image">
                        <img src="assets/images/Gmc.jpg" alt="Genocide Memorial Cup">
                        <div class="artwork-overlay">
                            <a href="/ferwaba1/Cups/gmc.php" class="btn btn-outline">View GMC</a>
                        </div>
                    </div>
                    <div class="artwork-info">
                    <a href="/ferwaba1/Cups/gmc.php" style="text-decoration: none; color: inherit;"><h3>Genocide Memorial Cup(GMC)</h3></a> 
                    </div>
                </div>
                <div class="artwork-card">
                    <div class="artwork-image">
                        <img src="assets/images/RC.jpg" alt="rwanda cup">
                        <div class="artwork-overlay">
                            <a href="/ferwaba1/Cups/rwanda-cup.php" class="btn btn-outline">View Details</a>
                        </div>
                    </div>
                    <div class="artwork-info">
                       <a href="/ferwaba1/Cups/rwanda-cup.php" style="text-decoration: none; color: inherit;"><h3>Rwanda Cup</h3"></a>
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

    <!-- Reviews Section -->
    <section class="reviews-section">
        <div class="container">
            <div class="section-header">
                <h2>What Our Fans Say</h2>
                <p>Read reviews from our ferwaba community</p>
            </div>
            <div class="reviews-grid" id="reviews-container">
                <div class="review-card">
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">Ferwaba has truly elevated basketball in Rwanda. The competitions are world-class!</p>
                    <div class="review-author">
                        <strong>Uwase Claudine</strong>
                        <span>Basketball Fan</span>
                    </div>
                </div>
                <div class="review-card">
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">The RBL season was absolutely incredible. Can't wait for the next one!</p>
                    <div class="review-author">
                        <strong>Mugisha Eric</strong>
                        <span>Sports Enthusiast</span>
                    </div>
                </div>
                <div class="review-card">
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">Ferwaba is doing amazing work promoting basketball talent in Rwanda. Proud to be a supporter!</p>
                    <div class="review-author">
                        <strong>Ishimwe Grace</strong>
                        <span>Season Ticket Holder</span>
                    </div>
                </div>
            </div>
        </div>
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

        // Reviews rotation functionality
        const reviews = [
            {
                text: "Ferwaba has truly elevated basketball in Rwanda. The competitions are world-class!",
                author: "Uwase Claudine",
                role: "Basketball Fan"
            },
            {
                text: "The RBL season was absolutely incredible. Can't wait for the next one!",
                author: "Mugisha Eric",
                role: "Sports Enthusiast"
            },
            {
                text: "Ferwaba is doing amazing work promoting basketball talent in Rwanda. Proud to be a supporter!",
                author: "Ishimwe Grace",
                role: "Season Ticket Holder"
            },
            {
                text: "The Genocide Memorial Cup is a beautiful tribute. Amazing basketball and meaningful purpose.",
                author: "Nkurunziza Jean Paul",
                role: "Community Leader"
            },
            {
                text: "I love the energy at every Ferwaba game. The atmosphere is electric!",
                author: "Uwera Divine",
                role: "Student Athlete"
            },
            {
                text: "Watching our local teams compete at this level makes me so proud. Go Ferwaba!",
                author: "Habimana Patrick",
                role: "Long-time Fan"
            },
            {
                text: "The Legacy Cup showcases the future stars of Rwandan basketball. Inspiring!",
                author: "Mukamana Alice",
                role: "Basketball Coach"
            },
            {
                text: "Ferwaba's commitment to youth development is outstanding. Great for our community!",
                author: "Nsengiyumva David",
                role: "Parent"
            },
            {
                text: "Every game is a celebration of Rwandan talent and sportsmanship. Well done Ferwaba!",
                author: "Iradukunda Sarah",
                role: "Sports Journalist"
            },
            {
                text: "The quality of basketball has improved so much. Ferwaba is leading the way!",
                author: "Bizimana Robert",
                role: "Former Player"
            },
            {
                text: "From grassroots to professional level, Ferwaba supports it all. Truly impressive!",
                author: "Mukamazimpaka Jeanne",
                role: "Volunteer"
            },
            {
                text: "The venues, organization, and passion - everything about Ferwaba events is top-notch!",
                author: "Kamanzi Emmanuel",
                role: "Event Attendee"
            },
            {
                text: "Supporting Ferwaba means supporting the future of sports in Rwanda. Count me in!",
                author: "Ingabire Marie",
                role: "Sponsor"
            },
            {
                text: "The competitions bring our communities together. Basketball is more than a game here!",
                author: "Ndayisaba Samuel",
                role: "Local Resident"
            },
            {
                text: "Ferwaba has created opportunities for so many young athletes. Thank you for your work!",
                author: "Umutoni Christine",
                role: "Youth Advocate"
            }
        ];

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