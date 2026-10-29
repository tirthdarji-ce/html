# Practical 13 — JSON API

- `events.php`: GET lists events; POST creates an event for an authenticated admin.
- `crud.php`: demonstrates GET/POST/PUT/DELETE patterns.
- Test from the browser Network tab or with curl after importing `database.sql`.
- POST/PUT/DELETE requests should be sent with `Content-Type: application/json`.
- For a production deployment, add CSRF protection for cookie-authenticated writes, strict schema validation, and consistent status/error handling.
