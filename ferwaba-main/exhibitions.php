<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Exhibitions - Inkingi Art Space</title>
    <meta name="description" content="Explore our current, upcoming, and past exhibitions featuring contemporary African art and emerging artists.">
    <meta name="keywords" content="exhibitions, contemporary African art, art shows, gallery events, Inkingi Art Space">
    
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
                <a href="artists.php" class="nav-link">Artists</a>
                <a href="exhibitions.php" class="nav-link active">Exhibitions</a>
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
            <h1>Exhibitions</h1>
            <p>Discover our current, upcoming, and past exhibitions featuring contemporary African art</p>
        </div>
    </section>

    <!-- Current Exhibition -->
    <section class="current-exhibition">
        <div class="container">
            <div class="section-header">
                <h2>Current Exhibition</h2>
                <p>Now on display at Inkingi Art Space</p>
            </div>
            
            <div class="exhibition-featured">
                <div class="exhibition-image">
                    <img src="assets/images/exhibition-current.jpg" alt="Voices of Tomorrow Exhibition">
                </div>
                <div class="exhibition-content">
                    <div class="exhibition-badge">Current</div>
                    <h3>Voices of Tomorrow</h3>
                    <p class="exhibition-dates">March 1 - April 30, 2024</p>
                    <p class="exhibition-curator">Curated by Dr. Maria Santos</p>
                    <p class="exhibition-description">A celebration of emerging African artists and their innovative approaches to contemporary art. This exhibition showcases the next generation of creative voices who are redefining the boundaries of African art and challenging traditional narratives.</p>
                    <div class="exhibition-details">
                        <div class="detail-item">
                            <i class="fas fa-calendar"></i>
                            <span>Opening Reception: March 1, 6:00 PM</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-users"></i>
                            <span>Featuring 12 emerging artists</span>
                        </div>
                        <div class="detail-item">
                            <i class="fas fa-palette"></i>
                            <span>Mixed media, painting, sculpture</span>
                        </div>
                    </div>
                    <div class="exhibition-actions">
                        <a href="contact.php" class="btn btn-primary">Plan Your Visit</a>
                        <a href="gallery.php" class="btn btn-outline">View Artworks</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Exhibitions -->
    <section class="upcoming-exhibitions">
        <div class="container">
            <div class="section-header">
                <h2>Upcoming Exhibitions</h2>
                <p>Mark your calendar for these exciting upcoming shows</p>
            </div>
            
            <div class="exhibitions-grid">
                <div class="exhibition-card upcoming">
                    <div class="exhibition-image">
                        <img src="assets/images/exhibition-upcoming-1.jpg" alt="Cultural Crossroads">
                        <div class="exhibition-badge">Upcoming</div>
                    </div>
                    <div class="exhibition-info">
                        <h3>Cultural Crossroads</h3>
                        <p class="exhibition-dates">May 1 - June 30, 2024</p>
                        <p class="exhibition-curator">Curated by Prof. James Okonkwo</p>
                        <p class="exhibition-description">Exploring the intersection of traditional African art forms with contemporary global influences.</p>
                        <div class="exhibition-actions">
                            <a href="contact.php" class="btn btn-outline">Get Notified</a>
                        </div>
                    </div>
                </div>
                
                <div class="exhibition-card upcoming">
                    <div class="exhibition-image">
                        <img src="assets/images/exhibition-upcoming-2.jpg" alt="Digital Horizons">
                        <div class="exhibition-badge">Upcoming</div>
                    </div>
                    <div class="exhibition-info">
                        <h3>Digital Horizons</h3>
                        <p class="exhibition-dates">July 15 - August 31, 2024</p>
                        <p class="exhibition-curator">Curated by Dr. Fatima Al-Zahra</p>
                        <p class="exhibition-description">A showcase of digital art and new media from contemporary African artists.</p>
                        <div class="exhibition-actions">
                            <a href="contact.php" class="btn btn-outline">Get Notified</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Past Exhibitions -->
    <section class="past-exhibitions">
        <div class="container">
            <div class="section-header">
                <h2>Past Exhibitions</h2>
                <p>Explore our archive of previous exhibitions</p>
            </div>
            
            <div class="exhibitions-grid">
                <div class="exhibition-card past">
                    <div class="exhibition-image">
                        <img src="assets/images/exhibition-past-1.jpg" alt="Heritage Reimagined">
                        <div class="exhibition-badge">Past</div>
                    </div>
                    <div class="exhibition-info">
                        <h3>Heritage Reimagined</h3>
                        <p class="exhibition-dates">September - November 2023</p>
                        <p class="exhibition-curator">Curated by Dr. Fatima Al-Zahra</p>
                        <p class="exhibition-description">A retrospective of contemporary African art from the past decade.</p>
                        <div class="exhibition-actions">
                            <a href="#" class="btn btn-outline">View Archive</a>
                        </div>
                    </div>
                </div>
                
                <div class="exhibition-card past">
                    <div class="exhibition-image">
                        <img src="assets/images/exhibition-past-2.jpg" alt="Urban Narratives">
                        <div class="exhibition-badge">Past</div>
                    </div>
                    <div class="exhibition-info">
                        <h3>Urban Narratives</h3>
                        <p class="exhibition-dates">June - August 2023</p>
                        <p class="exhibition-curator">Curated by Prof. James Okonkwo</p>
                        <p class="exhibition-description">Exploring the stories and experiences of African urban life through contemporary art.</p>
                        <div class="exhibition-actions">
                            <a href="#" class="btn btn-outline">View Archive</a>
                        </div>
                    </div>
                </div>
                
                <div class="exhibition-card past">
                    <div class="exhibition-image">
                        <img src="assets/images/exhibition-past-3.jpg" alt="Women in Art">
                        <div class="exhibition-badge">Past</div>
                    </div>
                    <div class="exhibition-info">
                        <h3>Women in Art</h3>
                        <p class="exhibition-dates">March - May 2023</p>
                        <p class="exhibition-curator">Curated by Dr. Maria Santos</p>
                        <p class="exhibition-description">Celebrating the contributions of African women artists to contemporary art.</p>
                        <div class="exhibition-actions">
                            <a href="#" class="btn btn-outline">View Archive</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Exhibition Events -->
    <section class="exhibition-events">
        <div class="container">
            <div class="section-header">
                <h2>Exhibition Events</h2>
                <p>Join us for special events related to our exhibitions</p>
            </div>
            
            <div class="events-list">
                <div class="event-item">
                    <div class="event-date">
                        <span class="day">15</span>
                        <span class="month">MAR</span>
                    </div>
                    <div class="event-content">
                        <h3>Artist Talk: Contemporary Perspectives</h3>
                        <p class="event-time">6:00 PM - 8:00 PM</p>
                        <p class="event-description">Join us for an engaging discussion with featured artists from "Voices of Tomorrow" about their creative process and inspiration.</p>
                        <a href="contact.php" class="btn btn-outline">RSVP</a>
                    </div>
                </div>
                
                <div class="event-item">
                    <div class="event-date">
                        <span class="day">22</span>
                        <span class="month">MAR</span>
                    </div>
                    <div class="event-content">
                        <h3>Curator's Tour</h3>
                        <p class="event-time">2:00 PM - 3:00 PM</p>
                        <p class="event-description">Take a guided tour of "Voices of Tomorrow" with curator Dr. Maria Santos.</p>
                        <a href="contact.php" class="btn btn-outline">RSVP</a>
                    </div>
                </div>
                
                <div class="event-item">
                    <div class="event-date">
                        <span class="day">30</span>
                        <span class="month">MAR</span>
                    </div>
                    <div class="event-content">
                        <h3>Closing Reception</h3>
                        <p class="event-time">7:00 PM - 10:00 PM</p>
                        <p class="event-description">Celebrate the closing of "Voices of Tomorrow" with a special reception featuring live music and artist meet-and-greets.</p>
                        <a href="contact.php" class="btn btn-outline">RSVP</a>
                    </div>
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
</body>
</html>
