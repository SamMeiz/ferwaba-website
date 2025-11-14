<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inkingi Art Space - Contemporary African Art Gallery</title>
    <meta name="description" content="Inkingi Art Space is a vibrant cultural hub dedicated to showcasing contemporary African art and fostering creative dialogue within our community.">
    <meta name="keywords" content="African art, contemporary art, gallery, art space, cultural hub, exhibitions, artists">
    
    <!-- Open Graph Meta Tags -->
    <meta property="og:title" content="Inkingi Art Space - Contemporary African Art Gallery">
    <meta property="og:description" content="A vibrant cultural hub dedicated to showcasing contemporary African art and fostering creative dialogue within our community.">
    <meta property="og:type" content="website">
    <meta property="og:url" content="https://inkingiartspace.com">
    <meta property="og:image" content="https://inkingiartspace.com/assets/images/og-image.jpg">
    
    <!-- Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "ArtGallery",
        "name": "Inkingi Art Space",
        "description": "Contemporary African Art Gallery",
        "url": "https://inkingiartspace.com",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "123 Art District",
            "addressLocality": "Creative City",
            "addressRegion": "CC",
            "postalCode": "12345"
        },
        "telephone": "+1 (555) 123-4567",
        "email": "info@inkingiartspace.com"
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
                <a href="index.php">
                    <h1>Inkingi Art Space</h1>
                </a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <a href="index.php" class="nav-link active">Home</a>
                <a href="gallery.php" class="nav-link">Gallery</a>
                <a href="artists.php" class="nav-link">Artists</a>
                <a href="exhibitions.php" class="nav-link">Exhibitions</a>
                <a href="donations.php" class="nav-link highlight">Donations</a>
                <a href="about.php" class="nav-link">About</a>
                <a href="contact.php" class="nav-link">Contact</a>
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
        <div class="hero-carousel">
            <div class="hero-slide active">
                <div class="hero-image" style="background-image: url('assets/images/hero-1.jpg')"></div>
                <div class="hero-content">
                    <div class="container">
                        <h2 class="hero-title">Contemporary African Art</h2>
                        <p class="hero-subtitle">Discover the vibrant world of contemporary African artists and their powerful expressions</p>
                        <a href="gallery.php" class="btn btn-primary">Explore Gallery</a>
                    </div>
                </div>
            </div>
            <div class="hero-slide">
                <div class="hero-image" style="background-image: url('assets/images/hero-2.jpg')"></div>
                <div class="hero-content">
                    <div class="container">
                        <h2 class="hero-title">Current Exhibition</h2>
                        <p class="hero-subtitle">"Voices of Tomorrow" - A celebration of emerging African artists</p>
                        <a href="exhibitions.php" class="btn btn-primary">View Exhibition</a>
                    </div>
                </div>
            </div>
            <div class="hero-slide">
                <div class="hero-image" style="background-image: url('assets/images/hero-3.jpg')"></div>
                <div class="hero-content">
                    <div class="container">
                        <h2 class="hero-title">Support the Arts</h2>
                        <p class="hero-subtitle">Help us continue our mission of promoting African art and culture</p>
                        <a href="donations.php" class="btn btn-primary">Donate Now</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero-controls">
            <button class="hero-prev" onclick="changeSlide(-1)"><i class="fas fa-chevron-left"></i></button>
            <button class="hero-next" onclick="changeSlide(1)"><i class="fas fa-chevron-right"></i></button>
        </div>
        <div class="hero-indicators">
            <span class="indicator active" onclick="currentSlide(1)"></span>
            <span class="indicator" onclick="currentSlide(2)"></span>
            <span class="indicator" onclick="currentSlide(3)"></span>
        </div>
    </section>

    <!-- Featured Artworks -->
    <section class="featured-artworks">
        <div class="container">
            <div class="section-header">
                <h2>Featured Artworks</h2>
                <p>Discover our curated selection of exceptional contemporary African art</p>
            </div>
            <div class="artworks-grid">
                <div class="artwork-card">
                    <div class="artwork-image">
                        <img src="assets/images/artwork-1.jpg" alt="Contemporary African Artwork">
                        <div class="artwork-overlay">
                            <a href="gallery.php" class="btn btn-outline">View Details</a>
                        </div>
                    </div>
                    <div class="artwork-info">
                        <h3>Harmony in Colors</h3>
                        <p class="artist-name">by Sarah Mwangi</p>
                        <p class="artwork-price">,500</p>
                    </div>
                </div>
                <div class="artwork-card">
                    <div class="artwork-image">
                        <img src="assets/images/artwork-2.jpg" alt="Contemporary African Artwork">
                        <div class="artwork-overlay">
                            <a href="gallery.php" class="btn btn-outline">View Details</a>
                        </div>
                    </div>
                    <div class="artwork-info">
                        <h3>Urban Rhythms</h3>
                        <p class="artist-name">by Kwame Asante</p>
                        <p class="artwork-price">,200</p>
                    </div>
                </div>
                <div class="artwork-card">
                    <div class="artwork-image">
                        <img src="assets/images/artwork-3.jpg" alt="Contemporary African Artwork">
                        <div class="artwork-overlay">
                            <a href="gallery.php" class="btn btn-outline">View Details</a>
                        </div>
                    </div>
                    <div class="artwork-info">
                        <h3>Cultural Heritage</h3>
                        <p class="artist-name">by Amina Okafor</p>
                        <p class="artwork-price">,800</p>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <a href="gallery.php" class="btn btn-secondary">View All Artworks</a>
            </div>
        </div>
    </section>

    <!-- Impact Counters -->
    <section class="impact-counters">
        <div class="container">
            <div class="counters-grid">
                <div class="counter-item">
                    <div class="counter-number" data-target="150">0</div>
                    <div class="counter-label">Artworks Exhibited</div>
                </div>
                <div class="counter-item">
                    <div class="counter-number" data-target="45">0</div>
                    <div class="counter-label">Featured Artists</div>
                </div>
                <div class="counter-item">
                    <div class="counter-number" data-target="25">0</div>
                    <div class="counter-label">Exhibitions Hosted</div>
                </div>
                <div class="counter-item">
                    <div class="counter-number" data-target="5000">0</div>
                    <div class="counter-label">Visitors Served</div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events -->
    <section class="upcoming-events">
        <div class="container">
            <div class="section-header">
                <h2>Upcoming Events</h2>
                <p>Join us for inspiring art events and cultural experiences</p>
            </div>
            <div class="events-grid">
                <div class="event-card">
                    <div class="event-date">
                        <span class="day">15</span>
                        <span class="month">MAR</span>
                    </div>
                    <div class="event-content">
                        <h3>Artist Talk: Contemporary Perspectives</h3>
                        <p class="event-time">6:00 PM - 8:00 PM</p>
                        <p class="event-description">Join us for an engaging discussion with featured artists about their creative process and inspiration.</p>
                        <a href="contact.php" class="btn btn-outline">RSVP</a>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-date">
                        <span class="day">22</span>
                        <span class="month">MAR</span>
                    </div>
                    <div class="event-content">
                        <h3>Opening Reception: New Voices</h3>
                        <p class="event-time">7:00 PM - 10:00 PM</p>
                        <p class="event-description">Celebrate the opening of our latest exhibition featuring emerging African artists.</p>
                        <a href="contact.php" class="btn btn-outline">RSVP</a>
                    </div>
                </div>
                <div class="event-card">
                    <div class="event-date">
                        <span class="day">30</span>
                        <span class="month">MAR</span>
                    </div>
                    <div class="event-content">
                        <h3>Art Workshop: Mixed Media Techniques</h3>
                        <p class="event-time">2:00 PM - 5:00 PM</p>
                        <p class="event-description">Learn contemporary mixed media techniques from professional artists.</p>
                        <a href="contact.php" class="btn btn-outline">Register</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Google Reviews Section -->
    <section class="reviews-section">
        <div class="container">
            <div class="section-header">
                <h2>What Our Visitors Say</h2>
                <p>Read reviews from our community and art enthusiasts</p>
            </div>
            <div class="reviews-grid" id="reviews-container">
                <!-- Reviews will be loaded dynamically via JavaScript -->
                <div class="review-card">
                    <div class="review-rating">
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                        <i class="fas fa-star"></i>
                    </div>
                    <p class="review-text">"Inkingi Art Space is a true gem in our city. The contemporary African art collection is breathtaking and the exhibitions are always thoughtfully curated."</p>
                    <div class="review-author">
                        <strong>Sarah Johnson</strong>
                        <span>Art Enthusiast</span>
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
                    <p class="review-text">"The gallery provides an amazing platform for African artists to showcase their work. The staff is knowledgeable and welcoming."</p>
                    <div class="review-author">
                        <strong>Michael Chen</strong>
                        <span>Collector</span>
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
                    <p class="review-text">"A beautiful space that celebrates African culture and contemporary art. Highly recommend visiting for anyone interested in art and culture."</p>
                    <div class="review-author">
                        <strong>Amara Okafor</strong>
                        <span>Cultural Advocate</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Donation CTA -->
    <section class="donation-cta">
        <div class="container">
            <div class="cta-content">
                <h2>Support Our Mission</h2>
                <p>Help us continue promoting contemporary African art and supporting emerging artists in our community.</p>
                <div class="donation-stats">
                    <div class="stat">
                        <span class="stat-number">,000</span>
                        <span class="stat-label">Raised This Year</span>
                    </div>
                    <div class="stat">
                        <span class="stat-number">,000</span>
                        <span class="stat-label">Annual Goal</span>
                    </div>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: 50%"></div>
                </div>
                <a href="donations.php" class="btn btn-primary btn-large">Donate Now</a>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="footer-content">
                <div class="footer-section">
                    <h3>Inkingi Art Space</h3>
                    <p>Contemporary African Art Gallery dedicated to showcasing exceptional talent and fostering cultural dialogue.</p>
                    <div class="social-links">
                        <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Quick Links</h4>
                    <ul>
                        <li><a href="gallery.php">Gallery</a></li>
                        <li><a href="artists.php">Artists</a></li>
                        <li><a href="exhibitions.php">Exhibitions</a></li>
                        <li><a href="about.php">About</a></li>
                    </ul>
                </div>
                <div class="footer-section">
                    <h4>Contact Info</h4>
                    <div class="contact-info">
                        <p><i class="fas fa-map-marker-alt"></i> Gasabo District, Kacyiru, 24 KG 550 st</p>
                        <p><i class="fas fa-phone"></i>(+250)788299791</p>
                        <p><i class="fas fa-envelope"></i> info@inkingiartspace.com</p>
                    </div>
                </div>
                <div class="footer-section">
                    <h4>Visit Us</h4>
                <div class="map-container" style="border-radius: 12px; overflow: hidden; max-width: 100%; margin: auto;">
                    <iframe
                      src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3989.709508591165!2d30.081878!3d-1.936026!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x19dca7f283280a65%3A0xc1e7669c3b4abb84!2sInkingi%20Arts%20Space!5e0!3m2!1sen!2srw!4v1726146000000!5m2!1sen!2srw"
                      width="100%"
                      height="350"
                      style="border:0;"
                      allowfullscreen=""
                      loading="lazy"
                      referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                    <div style="text-align: center; margin-top: 10px;">
                    <a href="http://google.com/maps/place/Inkingi+Arts+Space/@-1.949696,30.1006848,12z/data=!4m6!3m5!1s0x19dca7f283280a65:0xc1e7669c3b4abb84!8m2!3d-1.9360256!4d30.0853119!16s%2Fg%2F11vj6076p_?entry=ttu&g_ep=EgoyMDI1MDkwOS4wIKXMDSoASAFQAw%3D%3D" 
                     target="_blank" 
                     style="color: #0077cc; text-decoration: none; font-weight: 600;">
                    📍 Open Inkingi Arts Space on Google Maps
                    </a>
                </div>
                </div>
             </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; 2024 Inkingi Art Space. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="assets/js/main.js"></script>
    <script>
        // Hero carousel functionality
        let currentSlide = 0;
        const slides = document.querySelectorAll('.hero-slide');
        const indicators = document.querySelectorAll('.indicator');

        function showSlide(n) {
            slides[currentSlide].classList.remove('active');
            indicators[currentSlide].classList.remove('active');
            
            currentSlide = (n + slides.length) % slides.length;
            
            slides[currentSlide].classList.add('active');
            indicators[currentSlide].classList.add('active');
        }

        function changeSlide(direction) {
            showSlide(currentSlide + direction);
        }

        function currentSlideIndex(n) {
            showSlide(n - 1);
        }

        // Auto-advance carousel
        setInterval(() => {
            showSlide(currentSlide + 1);
        }, 5000);

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
    </script>
</body>
</html>
