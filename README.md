# bd_games

## Overview
Simple PHP/MySQL CRUD application for listing and managing games (name, description, grade). Includes authentication with role checks for admin and editor.

## Stack
- PHP (built-in development server works)
- MySQL

## Project Structure
- index.php — main entry point and listing view.
- includes/ — shared code:
  - includes/banco.php — database connection (default: host localhost, user root, empty password, database bd_games).
  - includes/login.php — session, login helpers, and role checks (admin, editor).
  - includes/functions.php — helper utilities (messages, thumbnails).
- game-*.php — create, edit, and delete flows (forms and actions).
- user-*.php — user registration, login, edit, and logout flows.
- css/, images/, icons/ — static assets.
- DB-bdgames.sql and bd_game_DB.sql — database schema and sample data.

## Setup
1) Create the database and import data:
   - Create a MySQL database named bd_games.
   - Import one of the provided SQL files (DB-bdgames.sql or bd_game_DB.sql).
2) Configure database credentials if needed:
   - Edit includes/banco.php to match your local MySQL host/user/password/database.
3) Start a local PHP server from the repository root:
   - php -S localhost:8000
4) Open the app:
   - http://localhost:8000/
5) Sign in:
   - Go to /user-login-form.php to log in. You can create accounts via /user-new-form.php or by inserting users with appropriate roles (admin or editor) in the database.

## Status
- Educational/demo project; no migrations or environment manager.
- Authentication uses PHP sessions and password_hash with a simple pre-hash step (see includes/login.php).
- Thumbnails are resolved via includes/functions.php; missing images fall back to images/indisponivel.png.

## License
No explicit license file is present in this repository.

