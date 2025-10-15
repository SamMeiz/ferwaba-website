-- FERWABA v1.6 – Full Schema with National Teams
SET time_zone = '+02:00';
CREATE DATABASE IF NOT EXISTS `ferwaba_db` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE `ferwaba_db`;

-- =========================
-- 👨‍💼 ADMINS
-- =========================
CREATE TABLE IF NOT EXISTS admins(
  id INT AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  password VARCHAR(100),
  role ENUM('SuperAdmin','SubAdmin') DEFAULT 'SubAdmin',
  is_active BOOLEAN DEFAULT 1
) ENGINE=InnoDB;

-- =========================
-- 🏀 LEAGUE TEAMS
-- =========================
CREATE TABLE IF NOT EXISTS teams(
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100),
  gender ENUM('Men','Women'),
  division ENUM('Division 1','Division 2'),
  location VARCHAR(100),
  logo VARCHAR(255),
  description TEXT
) ENGINE=InnoDB;

-- =========================
-- 👥 LEAGUE PLAYERS
-- =========================
CREATE TABLE IF NOT EXISTS players(
  id INT AUTO_INCREMENT PRIMARY KEY,
  team_id INT,
  name VARCHAR(100),
  position VARCHAR(50),
  height VARCHAR(10),
  nationality VARCHAR(50),
  jersey_number INT,
  photo VARCHAR(255),
  FOREIGN KEY(team_id) REFERENCES teams(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =========================
-- 🧑‍🏫 LEAGUE COACHES
-- =========================
CREATE TABLE IF NOT EXISTS coaches(
  id INT AUTO_INCREMENT PRIMARY KEY,
  team_id INT,
  name VARCHAR(100),
  role ENUM('Head Coach','Assistant Coach','Team Staff'),
  nationality VARCHAR(50),
  photo VARCHAR(255),
  FOREIGN KEY(team_id) REFERENCES teams(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- =========================
-- 🏆 GAMES + STANDINGS + PLAYOFFS
-- =========================
CREATE TABLE IF NOT EXISTS games(
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
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS standings(
  id INT AUTO_INCREMENT PRIMARY KEY,
  team_id INT,
  games_played INT DEFAULT 0,
  wins INT DEFAULT 0,
  losses INT DEFAULT 0,
  points INT DEFAULT 0,
  division ENUM('Division 1','Division 2'),
  gender ENUM('Men','Women'),
  FOREIGN KEY(team_id) REFERENCES teams(id)
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS playoffs(
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
) ENGINE=InnoDB;

-- =========================
-- 📸 GALLERY (LEAGUE)
-- =========================
CREATE TABLE IF NOT EXISTS gallery(
  id INT AUTO_INCREMENT PRIMARY KEY,
  team_id INT,
  image VARCHAR(255),
  caption VARCHAR(255),
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY(team_id) REFERENCES teams(id)
) ENGINE=InnoDB;

-- =========================
-- 📰 OPTIONAL MODULES
-- =========================
CREATE TABLE IF NOT EXISTS news(
  id INT AUTO_INCREMENT PRIMARY KEY,
  title VARCHAR(200),
  content TEXT,
  category ENUM('Latest','Transfers','Injuries','Squad Updates') DEFAULT 'Latest',
  image VARCHAR(255),
  video_url VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE IF NOT EXISTS shop_items(
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(150),
  description TEXT,
  category ENUM('Jerseys','Kits','Gear') DEFAULT 'Jerseys',
  price DECIMAL(10,2) DEFAULT 0,
  image VARCHAR(255),
  is_active BOOLEAN DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- =========================
-- 🌍 NATIONAL TEAMS MODULE
-- =========================

-- Core teams (Senior, U18, U16)
CREATE TABLE IF NOT EXISTS national_teams(
  id INT AUTO_INCREMENT PRIMARY KEY,
  category ENUM('Senior','U18','U16') NOT NULL,
  gender ENUM('Men','Women') NOT NULL,
  team_name VARCHAR(150),
  description TEXT,
  logo VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- Players for national teams
CREATE TABLE IF NOT EXISTS national_players(
  id INT AUTO_INCREMENT PRIMARY KEY,
  national_team_id INT,
  full_name VARCHAR(100),
  position VARCHAR(50),
  height VARCHAR(10),
  nationality VARCHAR(50),
  jersey_number INT,
  photo VARCHAR(255),
  FOREIGN KEY (national_team_id) REFERENCES national_teams(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Coaches & staff for national teams
CREATE TABLE IF NOT EXISTS national_coaches(
  id INT AUTO_INCREMENT PRIMARY KEY,
  national_team_id INT,
  full_name VARCHAR(100),
  role ENUM('Head Coach','Assistant Coach','Team Staff') DEFAULT 'Team Staff',
  nationality VARCHAR(50),
  photo VARCHAR(255),
  FOREIGN KEY (national_team_id) REFERENCES national_teams(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- Gallery for each national team
CREATE TABLE IF NOT EXISTS national_gallery(
  id INT AUTO_INCREMENT PRIMARY KEY,
  national_team_id INT,
  image VARCHAR(255),
  caption VARCHAR(255),
  uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (national_team_id) REFERENCES national_teams(id) ON DELETE CASCADE
) ENGINE=InnoDB;

-- =========================
-- 🧍‍♂️ SEED SUPER ADMIN
-- =========================
INSERT INTO admins(full_name,email,password,role,is_active)
VALUES ('Super Admin','admin@ferwaba.rw', SHA1('admin123'), 'SuperAdmin', 1)
ON DUPLICATE KEY UPDATE email=email;
