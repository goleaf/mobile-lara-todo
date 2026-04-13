## 🗓️ 2026-04-13 — Auth flows get real validation (and a design north star)

Hey! Here is what changed today in this project:

### What's New
The app now includes a complete first-pass authentication surface for guests: sign in, sign up, forgot password, reset password, and logout are all wired into the Laravel app. Those screens now validate through dedicated Form Request classes (with friendly, human messages), so the rules live in one place and behave consistently across the UI. A repo-specific `design.md` was added as a “north star” for the Material 3 direction, including tokens, layout rules, and component patterns we can follow as the Todo features land.

### What Was Improved
The auth Livewire components were simplified by sharing a small validation concern, eliminating duplicated rule arrays and making it harder for the UI and backend expectations to drift apart. The register screen now shows the “password confirmation” error in the place users expect (under the confirmation field), even though the underlying rule is attached to `password`. Automated feature coverage was expanded to include stricter password rules and more validation edge cases, giving the guest journey better regression protection.

### What Was Removed or Cleaned Up
An accidental Office lock file in `_docs` was removed so it does not get mistaken for real documentation. The repository now ignores those temporary `~$` doc files going forward, which keeps future commits cleaner and reduces noise during review.

### Files That Changed
- `.gitignore` — now ignores temporary Office lock files inside `_docs`
- `AGENTS.md` — adds repository-specific contributor guidance for architecture, naming, testing, and UI expectations
- `README.md` — replaces the default Laravel readme with project-specific setup, stack, architecture, and roadmap notes
- `_docs/todo-app-plan.docx` — adds the product roadmap document referenced by the repository guidance
- `app/Http/Requests/Auth/ForgotPasswordRequest.php` — centralizes forgot-password validation and enforces that the email exists
- `app/Http/Requests/Auth/LoginRequest.php` — centralizes login validation and adds a minimum password length rule
- `app/Http/Requests/Auth/RegisterRequest.php` — centralizes registration validation and adds friendly, user-facing messages
- `app/Http/Controllers/Auth/LogoutController.php` — adds a dedicated logout endpoint that clears the session safely
- `app/Livewire/Auth/ForgotPasswordComponent.php` — adds the forgot-password flow and reset-link dispatch behavior
- `app/Livewire/Auth/LoginComponent.php` — adds the login form logic, validation, and redirect back into the app shell
- `app/Livewire/Auth/RegisterComponent.php` — adds account creation with automatic sign-in after registration
- `app/Livewire/Auth/ResetPasswordComponent.php` — adds the password reset flow using Laravel’s password broker
- `app/Livewire/Concerns/UsesFormRequestValidation.php` — shares Form Request validation between Livewire components without duplication
- `changelog/changelog-2026-04-13.md` — records this update in a human-readable daily changelog
- `design.md` — documents the Material 3-inspired design system direction and token strategy for the app
- `resources/css/app.css` — adds mobile-first auth page styling, form controls, banners, and action buttons
- `resources/views/components/auth-card.blade.php` — adds a reusable auth card wrapper shared across guest flows
- `resources/views/layouts/auth.blade.php` — adds a dedicated auth layout with safe-area handling, fonts, Vite assets, and Livewire hooks
- `resources/views/livewire/auth/forgot-password-component.blade.php` — renders the reset-link request screen
- `resources/views/livewire/auth/login-component.blade.php` — renders the sign-in screen and auth navigation links
- `resources/views/livewire/auth/register-component.blade.php` — renders the account creation screen and displays confirmation errors where users expect them
- `resources/views/livewire/auth/reset-password-component.blade.php` — renders the password reset form
- `routes/web.php` — registers guest auth routes and an authenticated logout route alongside the existing app home route
- `tests/Feature/Auth/AuthPagesTest.php` — verifies auth flows work end to end, including stricter validation edge cases

### Why This Matters
This update moves the project from “screens that work” to “screens that hold up under real user input.” Centralizing validation keeps auth behavior consistent, improves error messaging, and gives the codebase a clean place to evolve rules without chasing them across multiple components. With a written design direction in the repo, future UI work can stay coherent and fast instead of reinventing decisions every time.

---
