# StudentHub sitemap

Home
├── About
├── Register → Login
├── Dashboard
│   ├── Profile
│   ├── Events
│   └── Study resources
├── Events
├── Contact
├── FAQ
├── Feedback
└── Admin (admin role only)
    ├── Student management
    ├── Event management
    └── Audit logs

# ER model (database.sql)
- users (1) —— (0..1) students
- students (1) —— (many) registrations
- events (1) —— (many) registrations
- users (1) —— (many) events as creator
- users (1) —— (many) audit_logs

`registrations` has a unique `(student_id, event_id)` key to prevent duplicate registration for the same event.
