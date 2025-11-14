<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Artists - Inkingi Art Space</title>
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
                    <h1>Inkingi Art Space</h1>
                </a>
            </div>
            <div class="nav-menu" id="nav-menu">
                <a href="index.php" class="nav-link">Home</a>
                <a href="gallery.php" class="nav-link">Gallery</a>
                <a href="artists.php" class="nav-link active">Artists</a>
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

    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <h1>Our Artists</h1>
            <p>Discover the talented contemporary African artists who bring their unique visions to life</p>
        </div>
    </section>

    <!-- Featured Artists -->
    <section class="featured-artists">
        <div class="container">
            <div class="section-header">
                <h2>Featured Artists</h2>
                <p>Meet the exceptional artists whose work graces our gallery</p>
            </div>
            
            <div class="artists-grid">
                <div class="artist-card featured">
                    <div class="artist-image">
                        <img src="assets/images/artist-1.jpg" alt="Sarah Mwangi">
                        <div class="artist-overlay">
                            <div class="social-links">
                                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="artist-info">
                        <h3>Sarah Mwangi</h3>
                        <p class="artist-location">Nairobi, Kenya</p>
                        <p class="artist-bio">Contemporary painter exploring themes of identity, culture, and social change through vibrant color palettes and bold compositions.</p>
                        <div class="artist-stats">
                            <span class="stat">12 Artworks</span>
                            <span class="stat">3 Exhibitions</span>
                        </div>
                        <a href="artist-detail.php?id=1" class="btn btn-outline">View Profile</a>
                    </div>
                </div>

                <div class="artist-card featured">
                    <div class="artist-image">
                        <img src="assets/images/artist-2.jpg" alt="Kwame Asante">
                        <div class="artist-overlay">
                            <div class="social-links">
                                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="artist-info">
                        <h3>Kwame Asante</h3>
                        <p class="artist-location">Accra, Ghana</p>
                        <p class="artist-bio">Sculptor and mixed media artist whose work examines the intersection of traditional African art forms with contemporary expression.</p>
                        <div class="artist-stats">
                            <span class="stat">8 Artworks</span>
                            <span class="stat">2 Exhibitions</span>
                        </div>
                        <a href="artist-detail.php?id=2" class="btn btn-outline">View Profile</a>
                    </div>
                </div>

                <div class="artist-card featured">
                    <div class="artist-image">
                        <img src="assets/images/artist-3.jpg" alt="Amina Okafor">
                        <div class="artist-overlay">
                            <div class="social-links">
                                <a href="#" class="social-link"><i class="fab fa-instagram"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-facebook"></i></a>
                                <a href="#" class="social-link"><i class="fab fa-twitter"></i></a>
                            </div>
                        </div>
                    </div>
                    <div class="artist-info">
                        <h3>Amina Okafor</h3>
                        <p class="artist-location">Lagos, Nigeria</p>
                        <p class="artist-bio">Photographer and digital artist capturing the essence of modern African life through innovative visual storytelling techniques.</p>
                        <div class="artist-stats">
                            <span class="stat">15 Artworks</span>
                            <span class="stat">4 Exhibitions</span>
                        </div>
                        <a href="artist-detail.php?id=3" class="btn btn-outline">View Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- All Artists -->
    <section class="all-artists">
        <div class="container">
            <div class="section-header">
                <h2>All Artists</h2>
                <p>Explore the complete roster of talented artists in our community</p>
            </div>
            
            <div class="artist-filters">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="painting">Painters</button>
                <button class="filter-btn" data-filter="sculpture">Sculptors</button>
                <button class="filter-btn" data-filter="photography">Photographers</button>
                <button class="filter-btn" data-filter="mixed-media">Mixed Media</button>
            </div>
            
            <div class="artists-grid all-artists-grid">
                <div class="artist-card" data-medium="painting">
                    <div class="artist-image">
                        <img src="assets/images/artist-4.jpg" alt="John Mutua">
                    </div>
                    <div class="artist-info">
                        <h3>John Mutua</h3>
                        <p class="artist-location">Kampala, Uganda</p>
                        <p class="artist-medium">Painter</p>
                        <a href="artist-detail.php?id=4" class="btn btn-outline">View Profile</a>
                    </div>
                </div>

                <div class="artist-card" data-medium="sculpture">
                    <div class="artist-image">
                        <img src="assets/images/artist-5.jpg" alt="Fatima Hassan">
                    </div>
                    <div class="artist-info">
                        <h3>Fatima Hassan</h3>
                        <p class="artist-location">Cairo, Egypt</p>
                        <p class="artist-medium">Sculptor</p>
                        <a href="artist-detail.php?id=5" class="btn btn-outline">View Profile</a>
                    </div>
                </div>

                <div class="artist-card" data-medium="photography">
                    <div class="artist-image">
                        <img src="assets/images/artist-6.jpg" alt="David Ochieng">
                    </div>
                    <div class="artist-info">
                        <h3>David Ochieng</h3>
                        <p class="artist-location">Nairobi, Kenya</p>
                        <p class="artist-medium">Photographer</p>
                        <a href="artist-detail.php?id=6" class="btn btn-outline">View Profile</a>
                    </div>
                </div>

                <div class="artist-card" data-medium="mixed-media">
                    <div class="artist-image">
                        <img src="assets/images/artist-7.jpg" alt="Grace Mbeki">
                    </div>
                    <div class="artist-info">
                        <h3>Grace Mbeki</h3>
                        <p class="artist-location">Johannesburg, South Africa</p>
                        <p class="artist-medium">Mixed Media</p>
                        <a href="artist-detail.php?id=7" class="btn btn-outline">View Profile</a>
                    </div>
                </div>

                <div class="artist-card" data-medium="painting">
                    <div class="artist-image">
                        <img src="assets/images/artist-8.jpg" alt="Mohammed Ali">
                    </div>
                    <div class="artist-info">
                        <h3>Mohammed Ali</h3>
                        <p class="artist-location">Casablanca, Morocco</p>
                        <p class="artist-medium">Painter</p>
                        <a href="artist-detail.php?id=8" class="btn btn-outline">View Profile</a>
                    </div>
                </div>

                <div class="artist-card" data-medium="sculpture">
                    <div class="artist-image">
                        <img src="assets/images/artist-9.jpg" alt="Nomsa Dlamini">
                    </div>
                    <div class="artist-info">
                        <h3>Nomsa Dlamini</h3>
                        <p class="artist-location">Cape Town, South Africa</p>
                        <p class="artist-medium">Sculptor</p>
                        <a href="artist-detail.php?id=9" class="btn btn-outline">View Profile</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Artist Spotlight -->
    <section class="artist-spotlight">
        <div class="container">
            <div class="spotlight-content">
                <div class="spotlight-image">
                    <img src="assets/images/artist-spotlight.jpg" alt="Artist Spotlight">
                </div>
                <div class="spotlight-text">
                    <h2>Artist Spotlight</h2>
                    <h3>Sarah Mwangi</h3>
                    <p>"Art has the power to bridge cultures, tell stories, and create understanding. Through my work, I aim to celebrate the richness of African heritage while engaging with contemporary global conversations."</p>
                    <p>Sarah Mwangi's latest series explores themes of migration, identity, and belonging through a vibrant palette that reflects both her Kenyan roots and her international experiences.</p>
                    <a href="artist-detail.php?id=1" class="btn btn-primary">Learn More</a>
                </div>
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
    </script>
</body>
</html>
