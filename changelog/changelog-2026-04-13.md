## 🗓️ 2026-04-13 — Authentication screens land in the mobile shell

Hey! Here is what changed today in this project:

### What's New
The app now includes a complete first-pass authentication surface for guests: sign in, sign up, forgot password, reset password, and logout are all wired into the Laravel app. These screens are built with Livewire and reuse a shared auth layout, so the new flows already feel like part of the same mobile-first product instead of bolted-on scaffolding. The repository also now includes the roadmap document the team has been referencing, which makes the project direction visible from inside the codebase.

### What Was Improved
The README was rewritten from the default Laravel boilerplate into project-specific guidance, so new contributors can understand the stack, architecture direction, and roadmap without guessing. The CSS layer gained dedicated auth styles for full-screen cards, safe-area-aware spacing, polished form fields, and clearer status and error states. Automated feature coverage was added for the new auth pages and Livewire flows, so the core guest journey now has fast regression protection.

### What Was Removed or Cleaned Up
An accidental Office lock file in `_docs` was removed so it does not get mistaken for real documentation. The repository now ignores those temporary `~$` doc files going forward, which keeps future commits cleaner and reduces noise during review.

### Files That Changed
- `.gitignore` — now ignores temporary Office lock files inside `_docs`
- `AGENTS.md` — adds repository-specific contributor guidance for architecture, naming, testing, and UI expectations
- `README.md` — replaces the default Laravel readme with project-specific setup, stack, architecture, and roadmap notes
- `_docs/todo-app-plan.docx` — adds the product roadmap document referenced by the repository guidance
- `app/Http/Controllers/Auth/LogoutController.php` — adds a dedicated logout endpoint that clears the session safely
- `app/Livewire/Auth/ForgotPasswordComponent.php` — adds the forgot-password flow and reset-link dispatch behavior
- `app/Livewire/Auth/LoginComponent.php` — adds the login form logic, validation, and redirect back into the app shell
- `app/Livewire/Auth/RegisterComponent.php` — adds account creation with automatic sign-in after registration
- `app/Livewire/Auth/ResetPasswordComponent.php` — adds the password reset flow using Laravel’s password broker
- `changelog/changelog-2026-04-13.md` — records this update in a human-readable daily changelog
- `resources/css/app.css` — adds mobile-first auth page styling, form controls, banners, and action buttons
- `resources/views/components/auth-card.blade.php` — adds a reusable auth card wrapper shared across guest flows
- `resources/views/layouts/auth.blade.php` — adds a dedicated auth layout with safe-area handling, fonts, Vite assets, and Livewire hooks
- `resources/views/livewire/auth/forgot-password-component.blade.php` — renders the reset-link request screen
- `resources/views/livewire/auth/login-component.blade.php` — renders the sign-in screen and auth navigation links
- `resources/views/livewire/auth/register-component.blade.php` — renders the account creation screen
- `resources/views/livewire/auth/reset-password-component.blade.php` — renders the password reset form
- `routes/web.php` — registers guest auth routes and an authenticated logout route alongside the existing app home route
- `tests/Feature/Auth/AuthPagesTest.php` — verifies guest auth pages render and the Livewire auth flows work end to end

### Why This Matters
This update moves the project from a static foundation toward a real application people can enter and use. It gives the app a proper authentication entry point, makes the repo easier to understand for the next developer, and adds enough test coverage to keep the new account flows stable as the rest of the todo features are built.

---
