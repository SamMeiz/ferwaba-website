-- Security Extensions for FERWABA

-- 📋 AUDIT LOGS
CREATE TABLE IF NOT EXISTS audit_logs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NULL,
    action VARCHAR(255) NOT NULL,
    details TEXT NULL,
    ip_address VARCHAR(45),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES admins(id) ON DELETE SET NULL
) ENGINE=InnoDB;

-- 🔐 LOGIN ATTEMPTS (For Rate Limiting)
CREATE TABLE IF NOT EXISTS login_attempts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ip_address VARCHAR(45) NOT NULL,
    attempt_time TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    is_successful BOOLEAN DEFAULT 0
) ENGINE=InnoDB;

-- 🛡️ 2FA SECRETS
ALTER TABLE admins ADD COLUMN IF NOT EXISTS two_factor_secret VARCHAR(100) NULL AFTER password;
ALTER TABLE admins ADD COLUMN IF NOT EXISTS two_factor_enabled BOOLEAN DEFAULT 0 AFTER two_factor_secret;
