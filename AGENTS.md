# Repository Guidelines

## Product Context
This repository is a mobile-first Todo application built with Laravel 13, Livewire 3, SQLite, Blade, and a Material Design 3 UI direction. The implementation roadmap lives in `_docs/todo-app-plan.docx`. That plan was drafted for Laravel 11, but contributors should align with the current repository state first and treat the document as the feature roadmap, not a version lock.

## Architecture Rules
- Keep controllers thin. They should route requests, validate input, and delegate work.
- Put business logic in `app/Actions/{Domain}` classes such as `CreateTaskAction`.
- Put validation in `app/Http/Requests/{Domain}` classes; do not validate complex forms directly in controllers.
- Use Livewire components for screen behavior and interaction, not for database-heavy domain logic.
- Scope all user data by ownership. Task, category, tag, reminder, and notification queries should always resolve through the authenticated user.
- Do not move query logic into Blade views. Views should render prepared data only.

## Project Structure
- `app/Actions/` - single-purpose application actions
- `app/Http/Controllers/` - HTTP entry points
- `app/Http/Requests/` - FormRequest validation
- `app/Livewire/` - screen and widget components
- `app/Models/` - Eloquent models, scopes, casts, and relationships
- `resources/views/layouts/` - shared page shells
- `resources/views/pages/` - full-page Blade views
- `resources/views/livewire/` - Livewire Blade templates
- `resources/css/app.css` - Material tokens, layout, and mobile shell styles
- `database/migrations/`, `database/factories/`, `database/seeders/` - schema and test data
- `tests/Feature/` and `tests/Unit/` - application test suites

## Naming Conventions
- Livewire classes: `app/Livewire/{Domain}/{FeatureNameComponent}.php`
- Action classes: `app/Actions/{Domain}/{VerbNounAction}.php`
- Request classes: `app/Http/Requests/{Domain}/{CreateNounRequest}.php`
- Livewire views: `resources/views/livewire/{domain}/{kebab-case-name}.blade.php`
- Blade partials: prefix partials with `_`, for example `_task_card.blade.php`
- Route names should remain grouped and prefixed, for example `app.home`

## UI Expectations
The app is explicitly mobile-first. Prefer full-screen cards, bottom sheets, floating action buttons, bottom navigation, safe-area padding, and Material Design 3 spacing and typography. Reuse tokens from `resources/css/app.css` instead of introducing one-off values. New form flows should support inline validation feedback and accessible states. Dark mode, reduced-motion support, and WCAG-oriented semantics are part of the roadmap and should not be designed as afterthoughts.

## Roadmap Summary
Work is planned in 12 phases:
1. Foundation, auth, preferences, shell, and theming
2. Core schema, models, relationships, and scopes
3. Task CRUD with Actions, Requests, Livewire screens, and bottom sheets
4. Categories, tags, search, and advanced filters
5. Subtasks, reminders, and notification center
6. Profile, settings, dashboard, motion, accessibility, onboarding, and performance polish

When implementing a feature, check the corresponding phase in `_docs/todo-app-plan.docx` before inventing new structure.

## Development Commands
- `composer setup` - install dependencies, prepare `.env`, generate the key, migrate, and build assets
- `composer dev` - run the Laravel server, queue listener, log tail, and Vite watcher
- `npm run dev` - frontend watcher only
- `npm run build` - production asset build
- `composer test` or `php artisan test` - run the test suite
- `./vendor/bin/pint` - apply PHP formatting

## Testing Expectations
Use PHPUnit 12 with the in-memory SQLite test configuration from `phpunit.xml`. Put HTTP and Livewire behavior in `tests/Feature` and isolated domain behavior in `tests/Unit`. Add factories for new models and cover critical flows such as auth, task CRUD, filters, notifications, and preferences as those features land.

## Security & Data Rules
- Put protected screens behind authentication middleware.
- Ensure `authorize()` checks ownership on request classes that mutate data.
- Keep mass assignment explicit with `$fillable`.
- Validate uploaded files server-side and avoid predictable filenames.
- Keep secrets in `.env` and surface new settings through config files and `.env.example`.
