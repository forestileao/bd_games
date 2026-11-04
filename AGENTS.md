# AGENTS.md

## 1) Purpose
Guidance for AI coding agents working in this PHP/MySQL repository. It explains structure, conventions, how to run locally, common agent tasks, safety constraints, and PR expectations.

## 2) Repo Structure
-  — main listing page (reads from MySQL, optional admin UI when logged in).
-  — shared PHP modules.
  -  — opens the MySQL connection with .
  -  — session/auth helpers (admin/editor roles, hashing utilities).
  -  — small view helpers (thumbnails, messages, back links).
-  — global styles.
- ,  — static assets.
-  — database schema and seed data ( database).
- , ,  — feature pages for auth and CRUD.

## 3) Conventions
- Plain PHP 7/8 with  for shared code; no frameworks.
- Use prepared statements for all SQL I/O (see ).
- Keep DB access in files that already touch ; do not introduce new layers.
- Keep styles in  and images under ; avoid inline base64.
- Keep icons in ; prefer reusing existing assets.
- Keep messages and small UI helpers in .

## 4) Build & Run
Prereqs: PHP 8.x CLI, MySQL 8 (or MariaDB), a web browser.
1. Create the database and import schema/seed:
   - 
   -  (or )
2. Configure DB credentials for local dev in  if they differ from /empty.
3. Start a local server: 
4. Visit .
5. Login at  to see admin/editor UI. Create users directly in the DB if none exist.

## 5) Tasks
- CRUD fixes or enhancements: update the corresponding  or  page.
- Listing/search tweaks: update  query and keep prepared statements.
- Visual adjustments: edit  and reuse assets in  and .
- DB changes: modify the SQL dumps; keep them idempotent and documented.

## 6) Safety
-  holds local credentials only; never commit real passwords or connection strings.
- Do not add new runtime dependencies or frameworks without an explicit request.
- Avoid committing large binaries or private data to .
- Treat any external input as untrusted and use prepared statements.

## 7) Review
- Manual smoke test:
  - Load  and sort by all options; try a search.
  - Login and, if admin/editor, exercise create/edit/delete flows.
  - Check for PHP notices/warnings and SQL errors.
- Keep PRs small and focused; describe the change and how to validate it locally.
