# Practical 12: Event CRUD and poster upload validation

## Objective
Complete Practical 12 in the supplied ITUE203 practical list using StudentHub.

## Step-by-step work
1. Open the `StudentHub_ITUE203_Complete` folder in VS Code.
2. Read the corresponding section in `README.md` and identify the files listed below.
3. Implement and run the relevant feature.
4. Test normal and error cases in the browser; open Developer Tools when checking JavaScript or Fetch.
5. Save screenshots and commit your changes to GitHub with a practical-specific commit message.

## Implementation focus
Use events_admin.php for create/list; validate category/date. For the advanced poster task, validate MIME type and size before storing under uploads.

## Files to review
- `index.html`, `style.css`, `script.js`
- `data/` for JSON practicals
- `php/` and `database.sql` for backend practicals

## Submission checklist
Test valid/invalid title/category/date and unauthorized admin access. Add poster upload with fileinfo MIME checks and randomized file names if required by your instructor.

## Git commit suggestion
`git add . && git commit -m "Complete practical 12: StudentHub" && git push`
