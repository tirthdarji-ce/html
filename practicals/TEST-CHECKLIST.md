# Final testing checklist

## Frontend
- [ ] All 11 pages open and every navigation link works.
- [ ] Logo and profile picture load without broken-image icons.
- [ ] Keyboard can reach links, inputs, buttons, and FAQ summaries.
- [ ] Mobile menu works and updates `aria-expanded`.
- [ ] Theme choice survives page refresh.
- [ ] Registration form rejects invalid email, mobile, short password, mismatched passwords, and missing terms.
- [ ] Events load through Fetch, search and category filter work, and pagination works.
- [ ] Layout checked at mobile, tablet, and desktop widths.
- [ ] Browser console contains no errors.

## PHP/MySQL
- [ ] Apache and MySQL start in XAMPP.
- [ ] `database.sql` imported successfully.
- [ ] `php/config.php` credentials match local MySQL.
- [ ] Duplicate registration is rejected.
- [ ] Password is stored as a hash.
- [ ] Login failure does not reveal whether email exists.
- [ ] Logout invalidates session.
- [ ] Student cannot access admin routes.
- [ ] Student search works and delete requires confirmation.
- [ ] Event creation is admin-only.
- [ ] API returns valid JSON and suitable status codes.
- [ ] Audit log captures admin changes.

## Evidence to capture
1. Home page desktop view.
2. Home page mobile view.
3. Registration invalid-input messages.
4. Registration valid input / backend result.
5. Events search/filter/pagination.
6. Database tables and foreign-key structure.
7. Login success and failure.
8. Admin dashboard and restricted-access attempt.
9. CRUD and API Network tab.
10. GitHub repository and README.
