# Practical 10: Secure login/logout, sessions, roles, timeout

## Objective
Complete Practical 10 in the supplied ITUE203 practical list using StudentHub.

## Step-by-step work
1. Open the `StudentHub_ITUE203_Complete` folder in VS Code.
2. Read the corresponding section in `README.md` and identify the files listed below.
3. Implement and run the relevant feature.
4. Test normal and error cases in the browser; open Developer Tools when checking JavaScript or Fetch.
5. Save screenshots and commit your changes to GitHub with a practical-specific commit message.

## Implementation focus
php/login.php uses password_verify and session_regenerate_id; logout clears session; admin routes use require_admin; student session timeout is 30 minutes.

## Files to review
- `index.html`, `style.css`, `script.js`
- `data/` for JSON practicals
- `php/` and `database.sql` for backend practicals

## Submission checklist
Test correct/incorrect login, logout, session timeout, direct admin URL as student, and role redirection.

## Git commit suggestion
`git add . && git commit -m "Complete practical 10: StudentHub" && git push`
