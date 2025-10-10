

# 📘 **FERWABA BASKETBALL WEBSITE – COMPLETE PROJECT DOCUMENTATION & MVP**

> **Version:** 1.5 (October 2025)
> **Scope:** Full frontend + admin backend, static results, media uploads, playoffs, no live streams
> **Design:** BAL/NBA-inspired modern theme, dark blue + gold
> **Tech Stack:** PHP, MySQL, HTML5, CSS3, JS
> **MVP:** Functional CRUD system for teams, players, coaches, games, standings, playoffs, and media galleries

---

## 🎯 **1. Project Overview**

FERWABA Basketball Website is a **league management, news, and fan hub** for Rwandan basketball:

* **League System:** Division 1 & Division 2, Men & Women
* **National Teams:** Senior, U18, U16, Men & Women
* **Playoffs:** BetPawa style, interactive bracket (Quarterfinal → Semifinal → Final → 3rd place)
* **News Hub:** Latest updates, transfers, injuries, squad news
* **Shop:** Jerseys, kits, merchandise
* **Admin Dashboard:** Full CRUD for all content, including media uploads

**MVP Scope:**

* Admin authentication & role system (SuperAdmin/SubAdmin)
* Team, player, coach CRUD with photos
* Standings & game management
* Playoffs management (start/end dates, duration, progression, eliminated teams)
* Gallery upload & display
* Static frontend pages reflecting current league info

---

## 🖼️ **2. Visual Design System**

**Color Palette:**

| Purpose                        | Color                             |
| ------------------------------ | --------------------------------- |
| Primary Background             | `#0047AB` (Dark Blue)             |
| Accent / Buttons               | `#FFB81C` (Gold)                  |
| Text                           | `#111111`                         |
| Highlight (Standings/Playoffs) | `#FFC107` / Green for progression |

**Typography:**

* Headings: Poppins Bold
* Body: Roboto Condensed / System Sans
* Layout: Responsive, mobile-first, grids for players/teams/gallery

**Navigation:**

**Main Nav:**

* Home 🏠
* Standings 📊 → Division 1 / Division 2
* Teams 🏆 → All Teams / Team Profiles
* Players 👤 → All Players / Leaderboards
* National Teams 🌍 → Senior Men/Women, U18/U16 Men/Women
* Games 📅 → Schedule / Results
* BetPawa Playoffs 🏆 → Bracket / Champion History
* News 📰 → Latest / Transfers / Injuries / Squad Updates
* Shop 🛒 → Jerseys / Kits / Gear

**Footer Nav:** About FERWABA / Contact / Sponsors / Social Media

**Admin Nav:** Dashboard / Manage Teams / Players / Rosters / National Teams / Coaches / Games / Playoffs / News / Shop

---

## 🗃️ **3. Database Schema (`ferwaba_db`)**

**Admins:**

```sql
CREATE TABLE admins (
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(100), -- MD5/SHA1 hashed
  role ENUM('SuperAdmin','SubAdmin') DEFAULT 'SubAdmin',
  is_active BOOLEAN DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Teams:**

```sql
CREATE TABLE teams (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  gender ENUM('Men','Women'),
  division ENUM('Division 1','Division 2'),
  location VARCHAR(100),
  logo VARCHAR(255),
  description TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
```

**Players:**

```sql
CREATE TABLE players (
  id INT AUTO_INCREMENT PRIMARY KEY,
  team_id INT,
  name VARCHAR(100),
  position VARCHAR(50),
  height VARCHAR(10),
  nationality VARCHAR(50),
  jersey_number INT,
  photo VARCHAR(255),
  FOREIGN KEY(team_id) REFERENCES teams(id)
);
```

**Coaches:**

```sql
CREATE TABLE coaches (
  id INT AUTO_INCREMENT PRIMARY KEY,
  team_id INT,
  name VARCHAR(100),
  role ENUM('Head Coach','Assistant Coach','Team Staff'),
  nationality VARCHAR(50),
  photo VARCHAR(255),
  FOREIGN KEY(team_id) REFERENCES teams(id)
);
```

**Games:**

```sql
CREATE TABLE games (
  id INT AUTO_INCREMENT PRIMARY KEY,
  home_team_id INT,
  away_team_id INT,
  game_date DATE,
  location VARCHAR(100),
  home_score INT DEFAULT 0,
  away_score INT DEFAULT 0,
  division ENUM('Division 1','Division 2'),
  gender ENUM('Men','Women'),
  status ENUM('Scheduled','Completed') DEFAULT 'Scheduled',
  highlight_url VARCHAR(255),
  FOREIGN KEY(home_team_id) REFERENCES teams(id),
  FOREIGN KEY(away_team_id) REFERENCES teams(id)
);
```

**Standings:**

```sql
CREATE TABLE standings (
  id INT AUTO_INCREMENT PRIMARY KEY,
  team_id INT,
  games_played INT DEFAULT 0,
  wins INT DEFAULT 0,
  losses INT DEFAULT 0,
  points INT DEFAULT 0,
  division ENUM('Division 1','Division 2'),
  gender ENUM('Men','Women'),
  FOREIGN KEY(team_id) REFERENCES teams(id)
);
```

**Playoffs:**

```sql
CREATE TABLE playoffs (
  id INT AUTO_INCREMENT PRIMARY KEY,
  stage ENUM('Quarterfinal','Semifinal','Final','3rd Place'),
  start_date DATE,
  end_date DATE,
  home_team_id INT,
  away_team_id INT,
  home_score INT DEFAULT 0,
  away_score INT DEFAULT 0,
  winner_team_id INT,
  status ENUM('Pending','Completed') DEFAULT 'Pending',
  FOREIGN KEY(home_team_id) REFERENCES teams(id),
  FOREIGN KEY(away_team_id) REFERENCES teams(id)
);
```

**Gallery:**

```sql
CREATE TABLE gallery (
  id INT AUTO_INCREMENT PRIMARY KEY,
  team_id INT,
  image VARCHAR(255),
  caption VARCHAR(255),
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(team_id) REFERENCES teams(id)
);
```

---

## 🌐 **4. Frontend Pages (Public)**

| Page                | Description                                                   |
| ------------------- | ------------------------------------------------------------- |
| `index.php`         | Home: Hero banner, news ticker, top standings, upcoming games |
| `teams.php`         | List all teams, filter by gender/division                     |
| `team.php`          | Team profile: roster, coaches, gallery, fixtures/results      |
| `players.php`       | Player list, leaderboards                                     |
| `national-team.php` | National teams roster (Senior, U18, U16)                      |
| `playoffs.php`      | Interactive bracket with eliminated teams shown               |
| `standings.php`     | Division standings                                            |
| `gallery.php`       | Team photos                                                   |
| `games.php`         | Schedule & results                                            |
| `news.php`          | News hub by category                                          |
| `shop.php`          | Merchandise shop                                              |
| `about.php`         | Federation info & contact                                     |

---

## 🔐 **5. Admin Backend Pages**

| File                                                 | Purpose                                                |
| ---------------------------------------------------- | ------------------------------------------------------ |
| `login.php`                                          | Admin login                                            |
| `logout.php`                                         | End session                                            |
| `auth.php`                                           | Session middleware                                     |
| `dashboard.php`                                      | Overview of teams, players, games, playoffs            |
| `admins.php` / `admin-form.php` / `delete-admin.php` | Manage admin users                                     |
| `teams.php` / `team-form.php`                        | CRUD for league & national teams                       |
| `players.php` / `player-form.php`                    | CRUD players, nationality, club affiliation            |
| `coaches.php` / `coach-form.php`                     | CRUD coaches with photo upload                         |
| `games.php` / `game-form.php`                        | Schedule fixtures / update results                     |
| `standings.php`                                      | Update points, auto-calculated                         |
| `playoffs.php`                                       | Manage playoff tree, rounds, winners, eliminated teams |
| `news.php` / `news-form.php`                         | Manage news articles                                   |
| `shop.php` / `shop-form.php`                         | Manage merchandise                                     |
| `gallery.php`                                        | Upload/manage team photos                              |

---

## ⚙️ **6. Folder Structure**

```
ferwaba/
├ admin/ (login, logout, dashboard, manage content, uploads)
├ css/style.css
├ js/main.js
├ includes/config.php
├ index.php
├ teams.php
├ team.php
├ national-team.php
├ playoffs.php
├ standings.php
├ gallery.php
├ players.php
├ games.php
├ news.php
├ shop.php
└ about.php
```

---

## ✅ **7. MVP Functional Flow**

1. Admin login → Dashboard overview
2. SuperAdmin can add SubAdmins
3. Add teams → add players/coaches → upload photos → update rosters
4. Schedule games → enter results → standings auto-update
5. Create playoffs → add teams → mark winners/eliminated → show bracket
6. Public frontend shows all teams, rosters, standings, playoff bracket, news, and gallery
7. Shop page shows merchandise

---

## 💡 **8. Security Notes (MVP vs Production)**

| Feature      | MVP                             | Production                              |
| ------------ | ------------------------------- | --------------------------------------- |
| Passwords    | MD5/SHA1 hashed                 | `password_hash()` + `password_verify()` |
| File Uploads | Manual URL/path input           | Secure upload with validation           |
| SQL Queries  | Prepared statements recommended | Keep as-is                              |
| XSS          | `htmlspecialchars()`            | Keep as-is                              |
| Admin Roles  | SuperAdmin/SubAdmin             | Expandable roles (editor, viewer)       |


