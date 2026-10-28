# AGENTS.md

Guidance for coding agents working in this repository.

## Overview

- Plain PHP app with no framework and no package manager.
- Lists games with genre, producer, grade, and cover image.
- Login with two roles: admin and editor.
- UI text and identifiers are in Brazilian Portuguese (jogos, generos, produtoras, usuarios, nota, capa).

## Layout

- Entry pages: `index.php` (list, search, sort via the `o` and `c` query parameters), `detalhes.php`.
- Game CRUD: `game-new.php`, `game-edit.php`, `game-delete.php`.
  - Forms: `game-new-form.php`, `game-edit-form.php` (delete has no form).
  - `game-crud-script.php` holds the JavaScript helpers for edit and delete.
- User pages: `user-login.php`, `user-logout.php`, `user-new.php`, `user-edit.php`.
  - Forms: `user-login-form.php`, `user-new-form.php`, `user-edit-form.php` (logout has no form).
- Shared includes:
  - `includes/banco.php`: mysqli connection.
  - `includes/login.php`: session, hash helpers, `is_logado`, `is_admin`, `is_editor`.
  - `includes/functions.php`: `thumb`, `voltar`, `msg_sucesso`, `msg_aviso`, `msg_error`.
- Partials: `topo.php` (header and nav), `rodape.php`. `_modelo.php` is a page template.
- Assets: `css/styles.css`, `icons/`, `images/` (cover uploads).
- Database: `bd_game_DB.sql` and `DB-bdgames.sql`. Both define the tables generos, jogos, produtoras, and usuarios.

## Running locally

- Needs PHP with the mysqli extension and MySQL or MariaDB, for example under XAMPP.
- Import one SQL dump into a database named `bd_games`.
- `includes/banco.php` connects to localhost as root with an empty password.
- Serve the repository root and open `index.php`.
- There are no automated tests, linter, or build in this repository.

## Conventions

- Each page starts with `require_once` of `includes/banco.php`, `includes/login.php`, and `includes/functions.php`.
- Use prepared statements with `bind_param` for all queries, as `index.php` and `game-new.php` do.
- Gate admin actions with `is_admin()` and `is_logado()`. Show `msg_aviso("Área Restrita!")` otherwise.
- Report outcomes with `msg_sucesso`, `msg_aviso`, and `msg_error`. Link back with `voltar()`.
- Follow the existing indentation and Portuguese naming for new database fields and variables.
- Escape output with `htmlspecialchars` in new code.

## Known quirks (existing issues, not patterns)

Do not copy these into new code.

- Passwords go through `cripto` (a character shift) before `password_hash`. Keep `gera_hash` and `testar_hash` together so hashes stay verifiable.
- Output in `topo.php` is not escaped.
- Upload handling in `game-new.php` trusts the original file name.
- Credentials are hardcoded in `includes/banco.php`.

## Verification for agents

- No test suite exists.
- If `php` is installed, run `php -l` on each changed PHP file. Otherwise review manually.
- Do not claim a change was run against the database unless it was.
