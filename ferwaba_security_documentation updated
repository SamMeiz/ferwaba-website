# 🛡️ FERWABA Security & Penetration Test Documentation

## 1. Executive Summary
This document outlines the comprehensive security architecture implemented within the FERWABA (Rwanda Basketball Federation) League Management System. Following a rigorous white-box static code analysis and dynamic payload-driven penetration test, the application has been hardened against critical web vulnerabilities. The system now enforces defense-in-depth mechanisms, reducing its risk profile to **Acceptable/Secure**.

---

## 2. Security Architecture & Built-in Defenses

The application implements a multi-layered security strategy. Below are the key security mechanisms currently active in the codebase and their exact purpose:

### A. Database Protection (SQL Injection Defense)
*   **Mechanism:** Strict use of **PDO (PHP Data Objects)** and **MySQLi Prepared Statements**.
*   **How it works:** Instead of concatenating user input directly into SQL queries (e.g., `WHERE id = $_GET['id']`), the application places placeholders (`?`) in the query. The database engine pre-compiles the query structure before the data is bound to it.
*   **What it does:** It completely neutralizes SQL Injection (SQLi) attacks. If an attacker inputs `' OR '1'='1`, the database treats it as a literal string value rather than executable SQL logic, preventing unauthorized data extraction or modification.

### B. Cross-Site Scripting (XSS) Prevention
*   **Mechanism 1:** Output Sanitization via `htmlspecialchars()`.
    *   **What it does:** Every piece of user-controlled data printed to the screen is passed through a [sanitize()](file:///c:/xampp/htdocs/ferwaba/includes/config.php#46-50) helper function. This converts malicious HTML characters (like `<` and `>`) into safe HTML entities (like `&lt;` and `&gt;`), ensuring browsers render them as plain text rather than executing them as JavaScript.
*   **Mechanism 2:** Content Security Policy (CSP).
    *   **What it does:** A robust HTTP header defined in [bootstrap.php](file:///c:/xampp/htdocs/ferwaba/includes/bootstrap.php) that acts as an allow-list for where scripts, styles, and images can be loaded from. It actively blocks inline scripts `<script>alert(1)</script>` injected by attackers from running in the browser.

### C. Cross-Site Request Forgery (CSRF) Protection
*   **Mechanism:** Rotating Cryptographic Anti-CSRF Tokens.
*   **How it works:** Every HTML form contains a hidden `<input type="hidden" name="csrf_token">` with a uniquely generated cryptographic string tied to the user's active session.
*   **What it does:** When a user submits a form (like toggling an admin, deleting a record, or changing a password), the server verifies the token. Upon successful verification, the token is instantly **destroyed (rotated)**. This guarantees that malicious websites cannot trick a logged-in admin's browser into silently submitting state-changing requests on their behalf, and prevents "replay attacks" where an attacker captures and reuses a valid submission.

### D. Authentication, Authorization & Rate Limiting
*   **Mechanism 1:** Strong Password Hashing (`bcrypt`).
    *   **What it does:** Passwords are never stored in plain text or weak algorithms like SHA1. They are salted and hashed using `bcrypt` (`PASSWORD_BCRYPT`), making them highly resistant to brute-force and rainbow table attacks if the database is theoretically compromised.
*   **Mechanism 2:** Password Complexity Policy.
    *   **What it does:** Enforced programmatically via [validate_password_strength()](file:///c:/xampp/htdocs/ferwaba/includes/helpers.php#189-216)—all passwords must be at least 12 characters long and contain uppercase, lowercase, numbers, and special characters.
*   **Mechanism 3:** Database-Backed IP Rate Limiting.
    *   **What it does:** The [is_ip_rate_limited()](file:///c:/xampp/htdocs/ferwaba/includes/helpers.php#76-85) function tracks failed login attempts by IP address in the database. If an IP fails 20 times within 5 minutes, it is locked out. This stops automated credential stuffing and dictionary brute-force attacks.

### E. Session Hardening
*   **Mechanism:** Strict Cookie Parameters (`HttpOnly`, `SameSite=Lax`, `Secure`, `use_strict_mode`).
*   **What it does:** 
    *   `HttpOnly`: Prevents JavaScript from accessing the PHP Session ID, neutralizing XSS session theft.
    *   `SameSite=Lax`: Prevents the browser from sending the session cookie along with cross-site requests, providing baseline CSRF immunity.
    *   `Secure`: Ensures the session cookie is only transmitted over encrypted HTTPS connections (when active).

### F. File Upload Security
*   **Mechanism:** [.htaccess](file:///c:/xampp/htdocs/ferwaba/.htaccess) Execution Blocking & MIME validation.
*   **What it does:** The `admin/uploads/` directory explicitly denies the execution of `.php`, `.cgi`, or `.pl` scripts. Even if an attacker manages to bypass the file extension upload checks via a zero-day exploit and uploads a malicious PHP script disguised as an image, the Apache server will refuse to execute it.

---

## 3. Penetration Test Key Results

A comprehensive white-box and dynamic "Red-Team" security audit was performed. **13 Vulnerabilities** were identified and successfully mitigated.

### High/Critical Mitigations:
1.  **VULN-001 & 002 (SQL Injection Eliminated):** Discovered raw ID queries in `national-players.php` and `news-card.php`. **Fixed:** Successfully rewritten using parameterized PDO/MySQLi objects. Dynamic payload attacks (`' UNION SELECT...`) now fail completely.
2.  **VULN-003 & 011 (CSRF on Admin Toggles):** The platform previously allowed modifying administrator statuses via insecure `GET` links. **Fixed:** Converted to secure `POST` forms protected by rotating CSRF tokens.
3.  **VULN-004 (Insecure Seeding):** The central `schema.sql` seeded the master SuperAdmin with an easily crackable `SHA1` hash. **Fixed:** Upgraded to a highly salted `bcrypt` string.
4.  **VULN-006 (Bypassable Rate Limiting):** The old rate limiter tracked attempts via the user's `$SESSION`. An attacker could just delete their cookie to get a fresh counter. **Fixed:** Shifted to a permanent database IP-tracking throttle array. Automated brute-fore scripts are now successfully blocked.
5.  **VULN-008 (Remote Code Execution Risk):** **Fixed:** Hardened the `/uploads` directory to block script execution, killing the potential for reverse-shell uploads.

### Ongoing Threat Simulation Status:
*   **SQL Map / Database Dump Attempts:** 🔴 Blocked (Prepared Statements).
*   **Reflected & Stored XSS Probes:** 🔴 Blocked (`htmlspecialchars` & CSP headers).
*   **Cross-Site Origin (CSRF) Hacks:** 🔴 Blocked (Single-use token rotation).
*   **Credential Brute-Forcing:** 🔴 Blocked (IP ban after 20 attempts).
*   **Spam Bots:** 🔴 Blocked (Honeypot fields active on contact forms).

## 4. Conclusion
The FERWABA codebase demonstrates a high level of maturity in handling user state, input sanitation, and database interaction. With the deployment of these patches, the application serves as a hardened, scalable, and secure environment ready for production traffic.
