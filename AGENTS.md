# AGENTS.md

Guide for coding agents working in this repository.

## Project overview

A games catalog in plain PHP. Visitors browse, search, and sort a list of games and open a detail page. Logged-in users with a role can manage games and users. UI text and identifiers are in Brazilian Portuguese (jogos, generos, produtoras, usuarios, nota, capa).

## Stack

- Plain PHP with mysqli. No framework, no Composer, no build step.
- MySQL or MariaDB. The dump header shows MariaDB 10.4 and PHP 7.2.
- Plain CSS in css/styles.css. Google Material Icons load from a CDN link in each page head.

## Local setup

1. Create a database named bd_games and load DB-bdgames.sql. bd_game_DB.sql is an identical copy (checked with diff).
2. includes/banco.php connects to localhost as root with an empty password, database bd_games. This localhost default is the only credential in the repo.
3. Serve the repository root with PHP (needs the mysqli extension), for example:

    php -S localhost:8000

4. Open http://localhost:8000/index.php.

There are no automated tests, linter, or build in this repository.

## Repository layout

Pages, all at the repository root:

- index.php: game list. Sort with the GET parameter o: p (producer), n1 (grade, high first), n2 (grade, low first). Any other value, including n, sorts by name. Search with the GET parameter c, which matches game name, producer, or genre.
- detalhes.php: game detail page, takes cod in the query string.
- game-new.php, game-edit.php, game-delete.php: game actions. game-new-form.php and game-edit-form.php are form partials. Delete has no form.
- user-login.php, user-logout.php, user-new.php, user-edit.php: user actions. user-login-form.php, user-new-form.php, and user-edit-form.php are form partials. Logout has no form.

Shared partials:

- topo.php: header and navigation.
- rodape.php: footer.
- game-crud-script.php: JavaScript (editGame, deleteGame) included only for admins.
- _modelo.php: page template. Copy it when creating a new page.

Other folders:

- includes/: banco.php (connection), login.php (session and auth helpers), functions.php (UI helpers).
- css/: stylesheet.
- icons/: UI icons.
- images/: game covers and uploads. images/indisponivel.png is the fallback cover.

Database dumps: DB-bdgames.sql and bd_game_DB.sql.

## Request and page pattern

- Each page starts with require_once of includes/banco.php, includes/login.php, and includes/functions.php, then renders inside div#app.
- Listing and detail pages include topo.php and rodape.php.
- Action pages show the form partial when the POST field nome (or the equivalent) is absent, and process the submit otherwise.
- Report outcomes with the message helpers below. Pages end by echoing voltar().

## Shared helpers

In includes/functions.php:

- msg_sucesso($m), msg_aviso($m), msg_error($m): return message markup (CSS classes sucesso, aviso, erro).
- voltar(): returns the back link to index.php.
- thumb($arc): returns ./images/$arc, or ./images/indisponivel.png when missing.

In includes/login.php:

- is_logado(), is_admin(), is_editor(): session checks.
- logout(): clears the session user data.
- gera_hash($senha) and testar_hash($senha, $hash): password hashing and verification.
- cripto($senha): shifts each character by one before hashing.

## Auth and roles

- includes/login.php starts the session and keeps user, nome, and tipo in $_SESSION.
- Roles come from usuarios.tipo: admin and editor.
- game-new.php and game-delete.php require is_admin() and is_logado(). game-edit.php allows is_admin() or is_editor(). user-new.php requires is_admin(). user-edit.php requires is_logado().
- Restricted pages answer with msg_aviso("Área restrita!"). Follow that wording in new code.
- Hash passwords only through gera_hash() and verify them through testar_hash(). Do not call password_hash directly: cripto() alters the input and stored hashes depend on it.

## Database

- Tables: jogos, generos, produtoras, usuarios.
- jogos: cod, nome, genero, produtora, descricao, nota, capa. genero and produtora hold generos.cod and produtoras.cod.
- generos: cod, genero. produtoras: cod, produtora, pais.
- usuarios: usuario, nome, senha, tipo.
- Use mysqli prepared statements with bind_param for every query that takes input, as index.php and game-new.php do.
- The connection uses utf8.
- Apply schema changes to both dumps, or ask first.

## Conventions

- Keep Portuguese names for files, functions, variables, columns, and UI text.
- Kebab-case page names grouped by entity prefix (game-*, user-*). Form partials end in -form.php.
- Cover uploads accept png, jpg, and jpeg only and are saved into images/.
- Follow the existing 4-space indentation.
- Escape all output with htmlspecialchars in new code.
- Documentation and agent-facing text is in English.

## Known quirks

These are existing issues, not patterns. Do not copy them into new code, and do not fix them unless asked.

- Passwords go through cripto (a character shift) before password_hash. Keep gera_hash and testar_hash together so hashes stay verifiable.
- Output in topo.php is not escaped.
- Upload handling in game-new.php trusts the original file name.
- Credentials are hardcoded in includes/banco.php.

## Verification

- No test suite exists.
- If php is installed, run php -l on each changed PHP file. Otherwise review by hand.
- Do not claim a change was run against the database unless it was. State in the change description how you checked it.

## What agents should not do

- Do not commit real credentials.
- Do not change a schema in only one dump.
- Do not add a framework, Composer, Docker, or a build step without asking.
