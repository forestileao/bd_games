# AGENTS.md

## Purpose
Give AI coding agents clear, minimal instructions for working in this repository safely and effectively. Keep guidance concise and focused on actions that preserve correctness and maintainability.

## Scope and Precedence
- This file governs the entire repository tree beneath the folder that contains it.
- If nested AGENTS.md files exist, the most deeply nested file takes precedence for files in its subtree.
- Direct instructions in an issue, task, or pull request take precedence over this file.
- Repository documents such as CONTRIBUTING, SECURITY, and CODEOWNERS (when present) also apply.

## Agent Persona and Tone
- Be concise, direct, and collaborative. Prefer short, actionable updates.
- State assumptions and next steps explicitly. Avoid filler.
- Use plain American English and repository terminology.

## Planning and Scoring Rules
- Plan before changing files; explain what you will do next in 1–2 sentences.
- Keep changes minimal and tightly scoped to the task. Avoid drive-by edits.
- Prefer branches and pull requests over direct pushes.
- Preserve behavior unless the task explicitly requests a change.
- Documentation-only tasks must not alter runtime behavior.

## Coding Conventions
- Follow the existing style and structure in touched files.
- Fix root causes rather than adding ad-hoc patches when practicable within scope.
- Do not add licenses, headers, or new tools unless requested.
- Use descriptive branch names (e.g., , , ).

## Testing and Validation
- Run repository-specific tests and linters when your change may affect behavior.
- For documentation-only changes, verify Markdown renders and links/paths are correct.
- Report which checks you ran and the outcomes. Do not claim results you did not run.

## Tooling and Commands
- Prefer fast, standard tools already used in this repo.
- Search: use  (ripgrep) when available; otherwise .
- Keep commands reproducible; avoid environment-specific flags.

## Communication Norms
- Before shell or file edits, post a brief preamble describing the immediate step.
- Reference files with clickable paths and line numbers (e.g., ).
- Summarize progress periodically and propose the next step for confirmation when appropriate.

## Repo-Specific Notes
- Ownership: refer to CODEOWNERS (if present) or repository settings for reviewers.
- No existing repository-specific agent rules were found at creation time.
