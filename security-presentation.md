# FERWABA Security Features Overview

---

## Slide 1 — Title
- FERWABA Security Features
- Admin + Public Site
- Version: Current codebase (local)

---

## Slide 2 — Architecture Snapshot
- PHP application with Admin and Public sections
- Central bootstrap initializes security controls
- Dual database access via PDO (primary) and mysqli (legacy)
- Access control enforced on admin entry points

---

## Slide 3 — Session Security
- HttpOnly cookies enabled
- Secure cookies when HTTPS is on
- Cookies restricted to cookie-based sessions only
- Session regeneration on successful admin login
- Sources: includes/bootstrap.php, admin/login.php

---

## Slide 4 — Authentication & Authorization
- Admin login required for admin routes
- Role-based protection for SuperAdmin actions
- Account active flag checked before login success
- Sources: includes/helpers.php, admin/includes/admin-header.php, admin/login.php

---

## Slide 5 — Password Security
- Password hashing with bcrypt for new/updated credentials
- Verification supports bcrypt and legacy SHA1/MD5
- Automatic hash upgrade on successful login
- Sources: includes/helpers.php, admin/login.php, admin/change-password.php

---

## Slide 6 — Brute Force Mitigation
- Rate limiting per session key for login attempts
- IP-based rate limiting using login_attempts table
- Lockout messaging on excessive attempts
- Session-based throttling provides basic DDoS resistance on login endpoints
- Sources: includes/bootstrap.php, admin/login.php, includes/helpers.php

---

## Slide 7 — Input/Output Safety
- Output sanitization via HTML escaping helper
- Centralized sanitize function used across templates
- Sources: includes/helpers.php

---

## Slide 8 — Database Safety
- PDO prepared statements with emulation disabled
- Exception mode enabled for database errors
- mysqli kept for legacy sections
- Sources: includes/bootstrap.php

---

## Slide 9 — Security Headers
- X-Frame-Options SAMEORIGIN
- X-XSS-Protection 1; mode=block
- X-Content-Type-Options nosniff
- Referrer-Policy strict-origin-when-cross-origin
- Sources: includes/bootstrap.php, .htaccess

---

## Slide 10 — Access Hardening via Web Server
- Directory listing disabled
- Direct access to config.php blocked
- Sensitive SQL and config files denied in /includes
- Sources: .htaccess, includes/.htaccess

---

## Slide 11 — Audit & Logging
- Central audit log helper for admin actions
- Audit log table defined in security migration
- Application error logging to logs/error.log
- Sources: includes/helpers.php, includes/security_migration.sql, includes/bootstrap.php, admin/login.php

---

## Slide 12 — Optional / Future-Ready Controls
- 2FA columns defined for admins (not enforced yet)
- Login attempts table available for DB-based throttling
- Admin dashboard monitoring for failed logins and top IPs
- SuperAdmin lock/unlock actions from failed login events
- Sources: includes/security_migration.sql, admin/dashboard.php
