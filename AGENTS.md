# AGENTS.md

Guide for coding agents working on bd_games.

## Overview

- Plain PHP with no framework, Composer, or build step.
- MySQL through mysqli. Runs under XAMPP-style Apache with PHP and MariaDB.
- The app lists games with search and sort, and has login for admin and editor roles.

## Setup

1. Import DB-bdgames.sql into a database named bd_games. bd_game_DB.sql is an identical copy.
2. The connection is hardcoded in includes/banco.php: host localhost, user root, empty password, database bd_games.
3. Serve the repository root through Apache and open index.php.

No PHP binary, tests, or linter are configured. The only check available is `php -l <file>` when PHP is installed.

## Layout

- includes/banco.php: mysqli connection `$banco`, with utf8 settings.
- includes/login.php: session_start, session defaults, cripto, gera_hash, testar_hash, logout, is_logado, is_admin, is_editor.
- includes/functions.php: thumb, voltar, msg_sucesso, msg_aviso, msg_error.
- topo.php is the header with the user menu. rodape.php is the footer.
- index.php lists games. detalhes.php shows one game.
- game-new.php, game-edit.php, game-delete.php are the game actions. game-new-form.php and game-edit-form.php are their forms.
- game-crud-script.php holds the JS for edit and delete. It is loaded only for admins.
- user-login.php, user-logout.php, user-new.php, user-edit.php and the user-*-form.php files handle users.
- _modelo.php is the page template. Copy it for a new page.
- css/styles.css, icons/, images/ for assets. Cover images are uploaded into images/.

## Page conventions

- Each page is a full HTML document.
- It starts with require_once of includes/banco.php, includes/login.php, and includes/functions.php, in that order.
- It renders inside div#app and uses the Material Icons font.
- A page ends with voltar() for the back link.
- A POST handler and its form are split: the page requires the matching form file when no POST data is present.

## Auth and roles

- Roles live in $_SESSION['tipo'] as admin or editor.
- Admin actions must check is_admin() && is_logado() before any work. When the check fails, show "Área restrita" through msg_aviso.
- Passwords use gera_hash and testar_hash, never plain text.

## Database

- Tables: generos, produtoras, jogos, usuarios.
- jogos.genero and jogos.produtora hold cod values from generos and produtoras. Writes look up those codes by name with subqueries.
- Always use prepared statements with bind_param, as in game-new.php and user-login.php.
- Never concatenate request data into SQL.

## Style

- Four-space indent.
- Variable and function names are in Portuguese. Keep them.
- UI text is in Portuguese.
- Use the msg_* helpers for feedback.
- Reuse thumb() for cover images.

## Known issues (do not fix unless asked)

- cripto() is a character-shift step applied before password_hash.
- Uploads trust the file extension and the original file name.
- game-delete.php is a GET action that deletes.
- The date and copyright in rodape.php are fixed.
- Several pages reuse generic titles.
- game-new.php checks `strlen($banco->error != 0)`. The comparison sits inside strlen, so the result does not reflect whether an error occurred. The error branch is unreliable.

## Agent rules

- Make small, focused edits.
- Match the existing page pattern.
- Do not commit credentials.
- Do not edit the SQL dumps unless the schema changes. If it does, update both copies.
