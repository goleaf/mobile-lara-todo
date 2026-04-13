## 🗓️ 2026-04-13 — The Todo schema lands (and auth gets cleaner)

Hey! Here is what changed today in this project:

### What's New
The database now has a real foundation for the Todo app: tasks, categories, tags, subtasks, attachments, and the pivot tables that connect them. Users also gained a couple of preferences at the schema level (an optional avatar and a theme preference) so we can build a more personal, polished experience without bolting it on later.

### What Was Improved
Authentication behavior was pushed into small Action classes, keeping controllers and Livewire components thin and making the flows easier to test. The login screen now supports “Remember me”, and the register form error rendering was tweaked so password confirmation mistakes show up exactly where users look for them.

### What Was Removed or Cleaned Up
Nothing major was removed in this update — this was mostly about adding a solid schema and tightening up existing auth code.

### Files That Changed
- `app/Actions/Auth/LoginUserAction.php` — encapsulates login + session regeneration and returns the intended redirect
- `app/Actions/Auth/LogoutUserAction.php` — centralizes safe logout + session invalidation and CSRF token regen
- `app/Actions/Auth/RegisterUserAction.php` — creates the user, hashes the password, fires `Registered`, and signs them in
- `app/Actions/Auth/SendPasswordResetAction.php` — sends reset links and converts broker failures into validation errors
- `app/Http/Controllers/Auth/LogoutController.php` — delegates logout work to an Action for a thinner controller
- `app/Http/Requests/Auth/ForgotPasswordRequest.php` — simplifies rule types and keeps forgot-password validation consistent
- `app/Http/Requests/Auth/LoginRequest.php` — aligns login validation and enables remember-me without widening inputs
- `app/Http/Requests/Auth/RegisterRequest.php` — trims redundant string rules while keeping registration constraints clear
- `app/Livewire/Auth/ForgotPasswordComponent.php` — uses the new Action instead of in-component broker calls
- `app/Livewire/Auth/LoginComponent.php` — adds `remember` state and delegates auth to the login Action
- `app/Livewire/Auth/RegisterComponent.php` — delegates user creation to the register Action
- `changelog/changelog-2026-04-13.md` — records this update in a human-readable daily changelog
- `database/migrations/0001_01_01_000000_create_users_table.php` — adds `avatar` + `theme_preference` fields for user personalization
- `database/migrations/2026_04_13_000100_create_categories_table.php` — adds user-owned categories for organizing tasks
- `database/migrations/2026_04_13_000200_create_tasks_table.php` — adds core tasks with status/priority, due dates, ordering, and soft deletes
- `database/migrations/2026_04_13_000300_create_subtasks_table.php` — adds subtasks for breaking work down with ordering support
- `database/migrations/2026_04_13_000400_create_tags_table.php` — adds user-owned tags for flexible categorization
- `database/migrations/2026_04_13_000500_create_task_category_table.php` — adds task↔category linking for many-to-many organization
- `database/migrations/2026_04_13_000600_create_task_tag_table.php` — adds task↔tag linking for many-to-many organization
- `database/migrations/2026_04_13_000700_create_attachments_table.php` — adds task attachments metadata for future uploads
- `resources/css/app.css` — adds a small “Remember me” toggle style that matches the MD3 look
- `resources/views/livewire/auth/login-component.blade.php` — adds the remember-me checkbox to the sign-in form
- `resources/views/livewire/auth/register-component.blade.php` — renders password/confirmation errors in the most intuitive spot
- `tests/Feature/Auth/AuthActionWiringTest.php` — ensures components/routes delegate to the new Actions
- `tests/Feature/Auth/AuthPagesTest.php` — expands auth coverage, including remember-me and validation behavior
- `tests/Feature/Database/TodoSchemaTest.php` — asserts Todo tables/columns exist and foreign keys cascade on delete
- `tests/Unit/Actions/Auth/AuthActionsTest.php` — unit-tests the Actions (login/register/logout/reset-link) end to end

### Why This Matters
With the schema in place, the Todo features can finally be built on something real — not placeholder tables — and the relationships (including cascades) are tested so future changes are safer. On the auth side, moving logic into Actions keeps the codebase easier to reason about, easier to test, and less likely to accumulate “just this one more thing” in Livewire components as the app grows.

---

### Audit (Automation run)
Just a quick housekeeping note: I re-scanned the repository on 2026-04-13 and confirmed the working tree is clean, `main` matches `origin/main`, and there are no extra local or remote branches to merge or delete. This is essentially a “nothing new to ship” check — but it’s still useful because it proves the repo is in a known-good state right now.

---

## 🗓️ 2026-04-13 — Final sweep (everything is already on main)

Hey! Here is what changed today in this project:

### What's New
No new features landed in this sweep — this was a verification pass to make sure nothing is left behind on another branch or sitting uncommitted.

### What Was Improved
We now have a fresh “all clear” snapshot: `main` matches `origin/main`, the working tree is clean, and there are no other branches to merge. That confidence matters when you’re about to start the next phase of work.

### What Was Removed or Cleaned Up
Nothing was removed in this sweep.

### Files That Changed
- `changelog/changelog-2026-04-13.md` — adds a final automation sweep entry confirming repo state

### Why This Matters
It’s easy for work to get stranded on a forgotten branch or for a small local tweak to go uncommitted. This sweep confirms the repo is in a “single source of truth” state again, so the next changes can start from a clean baseline.
