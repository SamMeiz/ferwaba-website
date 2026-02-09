# 🏀 FERWABA - Rwanda Basketball Federation Website
## Full Project Documentation (v2.0)

> **Last Updated:** January 29, 2026
> **Aesthetic:** Government Sport-Backed System (Rwanda National Colors)
> **Stack:** PHP 8.x, MySQL, HTML5, Vanilla CSS, JavaScript (ES6+), FontAwesome.

---

## 📋 1. Project Overview
The FERWABA website is a comprehensive management and information hub for the Rwanda Basketball Federation. It serves both as a public-facing portal for fans (news, standings, results) and a powerful administrative tool for managing the league's operations.

### Key Domains:
*   **League Management:** Division 1 & 2 (Men & Women).
*   **National Teams:** Senior, U18, and U16 levels.
*   **Tournament Systems:** BetPawa Playoffs with interactive visual brackets.
*   **Asset Management:** Media galleries, news hub, and merchandise shop.
*   **Statistics:** Detailed player-level and team-level stats tracking.

---

## 🎨 2. Design System & Aesthetics
The project underwent a major professional transformation in early 2026 to adopt a **"Government Sport-Backed"** look.

### Color Palette (Rwanda National Colors):
*   **Primary Blue:** `#0066cc` (Official Government Blue) - Headers, primary buttons, active states.
*   **Secondary Green:** `#00a651` (Rwanda Green) - Success states, winners, top-tier rankings.
*   **Accent Yellow:** `#fcd116` (Rwanda Yellow) - Champions, top scorers, navigation highlights.
*   **Backgrounds:** Clean whites (`#f8f9fa`) and subtle grays for hierarchy.

### Typography:
*   **Headings:** *Inter* (Professional, authoritative).
*   **Data/Stats:** *Roboto Mono* (For high readability in tables).

---

## 🛠️ 3. Technology Stack
*   **Server-Side:** PHP 8.1+ (Procedural with security helpers).
*   **Database:** MySQL 5.7+ / 8.0+.
*   **Frontend:** HTML5, CSS3 (Modern Flexbox/Grid), JavaScript (ES6).
*   **Assets:** FontAwesome for iconography, Google Fonts (Inter).
*   **Environment:** XAMPP / WAMP / LAMP (Local development).

---

## 📂 4. Directory Structure
```text
ferwaba/
├── admin/                  # Secure administrative dashboard
│   ├── includes/           # Admin-specific components (header, footer)
│   ├── uploads/            # Admin-uploaded media
│   ├── dashboard.php       # Stat overview & entry point
│   └── [feature].php       # CRUD pages for Teams, Players, Stats, etc.
├── assets/                 # Global assets
│   ├── css/                # style.css (Public), admin.css (Redesigned)
│   ├── js/                 # main.js (Animations, interactivity)
│   └── uploads/            # Publicly accessible images
├── competitions/           # Competition-specific pages
│   └── rbl/                # Rwanda Basketball League sub-site
├── ferwaba-main/           # Core landing pages and federation info
├── includes/               # Global configuration & helpers
│   ├── config.php          # Database connection & common functions
│   ├── schema.sql          # Primary database structure
│   └── ferwaba_db.sql      # Full database export with sample data
├── uploads/                # Root media storage
└── [root-pages].php        # Public-facing index, teams, standings, etc.
```

---

## 🗄️ 5. Database Schema (`ferwaba_db`)

### Core Tables:
*   **`admins`:** Authentication and roles (SuperAdmin/SubAdmin).
*   **`teams`:** League teams and National teams data.
*   **`players`:** Detailed profiles linked to teams.
*   **`coaches`:** Coaching staff profiles.
*   **`games`:** Fixtures, results, and score tracking.
*   **`standings`:** Dynamic team rankings (Auto-updated from game results).
*   **`playoffs`:** Tournament stages (Quarter-finals to Finals).
*   **`gallery` / `news` / `shop`:** Content management tables.

---

## 🚀 6. Key Features

### Public Frontend:
1.  **Home Page:** News ticker, live standings snippets, and featured hero images.
2.  **League Hub:** Division 1/2 switching, live results, and scheduled fixtures.
3.  **National Team Profile:** Roster display with club affiliation and positions.
4.  **BetPawa Playoff Bracket:** Visual tournament tree showing progression.
5.  **Gallery & Shop:** Interactive media browser and merchandise listings.

### Admin Panel (Professional Suite):
1.  **Dashboard Statistics:** Overview cards for total teams, players, and games.
2.  **Dynamic Standings Manager:** Filter by gender/division with automated rank calculation.
3.  **Playoff Tree Builder:** Drag-and-drop style configuration for tournament stages.
4.  **National Roster Management:** Specialized CRUD for handling player photos and club histories.
5.  **Role-Based Security:** SuperAdmin control over access levels.

---

## ⚙️ 7. Installation & Setup

1.  **Local Environment:** Install XAMPP with PHP 8.1+.
2.  **Cloning:** Place the project folder in `C:\xampp\htdocs\ferwaba\`.
3.  **Database Setup:**
    *   Open `phpMyAdmin`.
    *   Create a new database named `ferwaba_db`.
    *   Import `includes/ferwaba_db.sql`.
4.  **Configuration:**
    *   Open `includes/config.php`.
    *   Ensure `$DB_USER` and `$DB_PASS` match your local MySQL settings.
5.  **Access:**
    *   Frontend: `http://localhost/ferwaba/`
    *   Admin: `http://localhost/ferwaba/admin/`

---

## ✅ 8. Recent Progress (January 2026 Redesign)
The system was recently updated from v1.5 to v2.0:
*   **UI Unified:** All admin pages now use the professional blue/green/yellow Rwanda theme.
*   **Mobile Excellence:** Tables and brackets are now fully responsive with horizontal scrolling.
*   **Speed:** Cleaned up PHP logic in `admin-header.php` to prevent loading delays.
*   **Data Clarity:** Added "Games Behind" (GB) and "Win Percentage" calculation to standings.

---

## 📞 9. Support & Maintenance
Developed for the **Rwanda Basketball Federation**. All code is structured for easy extension (e.g., adding new competition types or integrating live statistics APIs).

---
**FERWABA - Rwanda Basketball Federation**  
*Powered by Rwanda Sports Technology*
