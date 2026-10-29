# Practical 14: Admin dashboard, role-based menu, audit log

## Objective
Complete Practical 14 in the supplied ITUE203 practical list using StudentHub.

## Step-by-step work
1. Open the `StudentHub_ITUE203_Complete` folder in VS Code.
2. Read the corresponding section in `README.md` and identify the files listed below.
3. Implement and run the relevant feature.
4. Test normal and error cases in the browser; open Developer Tools when checking JavaScript or Fetch.
5. Save screenshots and commit your changes to GitHub with a practical-specific commit message.

## Implementation focus
php/admin_dashboard.php aggregates counts; admin-only guard restricts access; students.php/events_admin.php write audit log records.

## Files to review
- `index.html`, `style.css`, `script.js`
- `data/` for JSON practicals
- `php/` and `database.sql` for backend practicals

## Submission checklist
Test admin vs student access, live counts, latest registrations, and audit log entries. Extend menu based on session role.

## Git commit suggestion
`git add . && git commit -m "Complete practical 14: StudentHub" && git push`
