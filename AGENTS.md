# AGENTS.md

Guide for coding agents working in this repository.

## Project overview

A games catalog. Visitors browse, search, and sort a list of games and open a detail page. Logged-in users with a role can manage games and users. All UI text is in Portuguese.

## Stack

- Plain PHP with mysqli. No framework, no Composer, no automated tests, no build step.
- MySQL or MariaDB. The dump header shows MariaDB 10.4 and PHP 7.2.
- Plain CSS in css/styles.css. Google Material Icons are loaded from a CDN link in each page head.

## Local setup

1. Create a database named bd_games and load the schema and seed data from DB-bdgames.sql. bd_game_DB.sql is an identical copy.
2. The connection in includes/banco.php is hardcoded: host localhost, user root, empty password, database bd_games.
3. Serve the repository folder with a PHP web server, for example:

    php -S localhost:8000

4. Open http://localhost:8000/index.php.

## Repository layout

Pages, all at the repository root:

- index.php: game list. Sort with the GET parameter o (values n, p, n1, n2; anything else sorts by name). Search with the GET parameter c.
- detalhes.php: game detail page, takes cod in the query string.
- game-new.php, game-edit.php, game-delete.php: game actions. game-new-form.php and game-edit-form.php are the form partials.
- user-login.php, user-logout.php, user-new.php, user-edit.php: user actions. user-login-form.php, user-new-form.php, and user-edit-form.php are the form partials.

Shared partials:

- topo.php: header and navigation.
- rodape.php: footer.
- game-crud-script.php: JavaScript (editGame, deleteGame) included only for admins.
- _modelo.php: page template. Copy it when creating a new page.

Other folders:

- includes/: banco.php (connection), login.php (session and auth helpers), functions.php (UI helpers).
- css/: stylesheet.
- icons/: UI icons.
- images/: game covers. images/indisponivel.png is the fallback cover.

Database dumps: DB-bdgames.sql and bd_game_DB.sql.

## Request and page pattern

- Each page requires includes/banco.php, includes/login.php, and includes/functions.php, then renders its content inside div#app.
- Pages that show listings or details include topo.php and rodape.php.
- Action pages (game-new.php, game-edit.php, user-new.php, user-edit.php, user-login.php) show the form partial when the POST field is absent, and process the submit otherwise.
- Feedback uses the message helpers below. Pages end by echoing voltar().

## Shared helpers

In includes/functions.php:

- msg_sucesso($m), msg_aviso($m), msg_error($m): return message markup (CSS classes sucesso, aviso, erro).
- voltar(): returns the back link to index.php.
- thumb($arc): returns the cover path under ./images/, or ./images/indisponivel.png when missing.

In includes/login.php:

- is_logado(), is_admin(), is_editor(): session checks.
- logout(): clears the session user data.
- gera_hash($senha) and testar_hash($senha, $hash): password hashing and verification.
- cripto($senha): shifts each character before hashing.

## Auth and roles

- includes/login.php starts the session and keeps user, nome, and tipo in $_SESSION.
- Roles come from usuarios.tipo: admin and editor.
- Guard pages with is_logado(), is_admin(), and is_editor(). Restricted pages answer with msg_aviso or msg_error ("Área restrita").
- Hash passwords only through gera_hash() and verify them through testar_hash(). Do not call password_hash directly: cripto() shifts characters before hashing, and stored hashes depend on that.

## Database

- Tables: jogos, generos, produtoras, usuarios.
- jogos.genero and jogos.produtora reference generos.cod and produtoras.cod.
- usuarios has usuario, nome, senha, and tipo.
- Use mysqli prepared statements with bind_param for queries that take input, as in game-new.php and index.php.
- The connection uses utf8.

## Conventions

- Portuguese names for files, functions, variables, columns, and UI text. Keep identifiers in Portuguese.
- Kebab-case page names grouped by entity prefix (game-*, user-*). Form partials end in -form.php.
- Cover uploads accept png, jpg, and jpeg only and are saved into images/.
- Source files use 4-space indentation and a PHP block at the top of each page for the requires.
- Documentation and agent-facing text is in English.

## What agents should not do

- Do not change a schema in only one dump. Apply schema changes to both DB-bdgames.sql and bd_game_DB.sql, or ask first.
- Do not commit real credentials.
- Do not add a framework, Composer, Docker, or a build step without asking.
- No automated tests exist. State in the change description how you checked the change by hand.
