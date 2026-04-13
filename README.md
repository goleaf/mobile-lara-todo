# Todo App

Mobile-first todo application built with Laravel 13, Livewire 3, SQLite, and a Material Design 3 visual system. The product roadmap comes from [`_docs/todo-app-plan.docx`](_docs/todo-app-plan.docx). That plan was originally written against Laravel 11, but this repository is already running on Laravel 13, so implementation should follow the current codebase first.

## Current Status

The repository currently contains the foundation layer:

- Laravel 13 app bootstrapped with Livewire 3
- SQLite-backed local development setup
- Mobile-first app shell and home screen
- Material-inspired layout, typography, and action styling in [`resources/css/app.css`](resources/css/app.css)
- A baseline feature test for the home page

The full task system, authentication flows, and dashboard features described in the plan are still in progress.

## Stack

- PHP 8.3
- Laravel 13
- Livewire 3
- SQLite
- Vite + Tailwind CSS 4
- Material Web components loaded in the Blade UI

## Project Structure

- `app/Actions/` - page and domain actions
- `app/Http/Controllers/` - route entry points
- `app/Http/Requests/` - request validation classes
- `app/Livewire/` - interactive Livewire components
- `resources/views/layouts/` - shared Blade layouts
- `resources/views/pages/` - page-level Blade views
- `resources/views/livewire/` - Livewire Blade templates
- `resources/css/app.css` - design tokens and mobile shell styling
- `database/` - SQLite file, migrations, factories, and seeders
- `tests/Feature` and `tests/Unit` - application test suites

## Local Development

```bash
composer setup
composer dev
```

`composer setup` installs PHP and Node dependencies, creates `.env`, generates the app key, runs migrations, and builds frontend assets.

`composer dev` starts the Laravel server, queue listener, log tail, and Vite watcher in one process group.

Useful single-purpose commands:

```bash
npm run dev
npm run build
composer test
./vendor/bin/pint
```

## Architecture Direction

The implementation plan is opinionated:

- Controllers should stay thin and delegate to Action classes.
- Request validation belongs in `FormRequest` classes.
- Livewire components own screen interaction, not business logic.
- Queries should stay scoped and user-aware.
- Blade views should render prepared data only.

The current home screen already follows this pattern through `HomePageController`, `ShowHomePageRequest`, `ShowHomePageAction`, and `MobileHomeShell`.

## Roadmap Summary

The plan is divided into 12 phases:

1. Foundation and authentication
2. Database schema and Eloquent models
3. Core task CRUD with Livewire screens
4. Categories, tags, search, and advanced filters
5. Subtasks, reminders, notifications, and profile settings
6. Dashboard, dark mode, accessibility, onboarding, and performance polish

## Testing

Tests run on PHPUnit 12 with an in-memory SQLite database configured in `phpunit.xml`.

```bash
php artisan test
```

Add feature coverage for HTTP and Livewire behavior in `tests/Feature` and keep isolated logic in `tests/Unit`.
