# StudentHub — ITUE203 Web Development Frameworks

This project is based on the supplied practical manual and the uploaded StudentHub HTML pages, logo, and profile photo.

## Folder structure

- `index.html`, `about.html`, `register.html`, `login.html`, `dashboard.html`, `events.html`, `profile.html`, `contact.html`, `admin.html`, `faq.html`, `feedback.html`: 11 linked pages.
- `style.css`: shared responsive CSS using CSS Grid, Flexbox, and mobile-first media queries.
- `script.js`: mobile navigation, saved light/dark theme, FAQ interaction, registration validation, and event search/filter/pagination.
- `assets/`: supplied logo and profile image.
- `data/`: sample JSON datasets (15 events, 15 students, 15 FAQs).
- `php/`: file-based form processing, PDO connection, secure registration/login, sessions, CRUD samples, JSON APIs, and admin dashboard.
- `database.sql`: MySQL schema and sample event data.
- `practicals/`: stepwise implementation guide for all 15 practicals.

## Run frontend (recommended)

1. Open the folder in VS Code.
2. Install/use the Live Server extension.
3. Right-click `index.html` → **Open with Live Server**.
4. Test all navigation links, mobile menu, theme toggle, registration validation, and event search/filter/pagination.

Do not open `events.html` directly with `file://` when testing `fetch()`; use Live Server or another local HTTP server.

## Run PHP/MySQL on macOS with XAMPP

1. Copy this whole `StudentHub_ITUE203_Complete` folder into `/Applications/XAMPP/htdocs/`.
2. Start **Apache** and **MySQL** from XAMPP Manager.
3. Open `http://localhost/phpmyadmin`.
4. Import `database.sql`.
5. Check `php/config.php` and set the database username/password to match your local MySQL.
6. Open `http://localhost/StudentHub_ITUE203_Complete/`.
7. PHP forms and database pages run only through Apache/PHP, not Live Server.

## Important test note

The frontend is a learning/demo project. PHP database pages require the SQL import and a configured MySQL account. Create an admin user by registering normally and then, in phpMyAdmin, change that user's `role` to `admin`. Passwords are hashed using `password_hash()`. Never store real passwords in source code.

## Practical-wise guidance

See `practicals/Practical-01.md` through `practicals/Practical-15.md` for steps, files, testing, and submission checklist. See `practicals/TEST-CHECKLIST.md` before submitting.
