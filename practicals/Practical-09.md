# Practical 9: Secure registration and password hashing

## Objective
Complete Practical 9 in the supplied ITUE203 practical list using StudentHub.

## Step-by-step work
1. Open the `StudentHub_ITUE203_Complete` folder in VS Code.
2. Read the corresponding section in `README.md` and identify the files listed below.
3. Implement and run the relevant feature.
4. Test normal and error cases in the browser; open Developer Tools when checking JavaScript or Fetch.
5. Save screenshots and commit your changes to GitHub with a practical-specific commit message.

## Implementation focus
php/register.php validates fields, checks duplicate email, hashes password, and inserts user/student rows using prepared statements.

## Files to review
- `index.html`, `style.css`, `script.js`
- `data/` for JSON practicals
- `php/` and `database.sql` for backend practicals

## Submission checklist
Test valid registration, duplicate email, malformed email/mobile, short password, and missing terms. Verify password_hash is not plain text.

## Git commit suggestion
`git add . && git commit -m "Complete practical 09: StudentHub" && git push`
