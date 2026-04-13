# Todo App Design System

## Purpose

This document defines the visual and interaction system for the mobile-first Todo app in this repository. It is based on the product roadmap in `_docs/todo-app-plan.docx`, the current Laravel + Livewire implementation, and a review of relevant official Google Material 3 guidance. It is not a verbatim copy of Google's docs; it is a repo-specific design translation for the web.

## Scope

This spec covers:

- theming and token architecture
- typography, color, shape, elevation, and spacing
- navigation and layout behavior across phone, tablet, and desktop
- form, auth, task, feedback, and dashboard component patterns
- accessibility, motion, and implementation handoff rules

This spec does not define backend behavior, database schema, or Livewire event contracts.

## Google Material 3 Findings Applied Here

The design direction is anchored to current Material 3 guidance:

- Material 3 theming is built from three subsystems: color, typography, and shape.
- Navigation bars are intended for three to five top-level destinations on compact layouts.
- Navigation rail is the large-screen counterpart for tablet and desktop layouts.
- Filled buttons are for primary emphasis; outlined and text buttons are for lower-emphasis actions.
- Outlined text fields are appropriate when we want explicit field boundaries, labels, and room for supporting or error text.
- A FAB should represent the most important action on a screen.
- Bottom sheets are secondary, anchored content rather than full route replacements.
- Minimum touch targets should remain at least 48dp-equivalent.
- Normal-size text should meet at least 4.5:1 contrast.

Design inference for this repo:

- Dynamic color is Android-specific in Google's guidance, so the web app should use static light and dark palettes that preserve Material 3 role semantics.
- Material Web components should be used where they fit cleanly in Blade and Livewire, with custom wrappers only for app-specific layout primitives such as task cards, auth cards, and mobile navigation.

## Product Design Principles

1. Glanceable first. Core task information must be readable within one thumb-reach scan.
2. One primary action per screen. Every screen gets one obvious next step.
3. Calm utility over visual noise. Use color to signal priority and state, not decoration.
4. Mobile first, adaptive second. Design for compact width first, then expand to rail and multi-column layouts.
5. Feedback must be immediate. Pressed, loading, success, undo, and error states cannot be silent.

## Visual Direction

The current shell already points in the right direction: soft surfaces, high-radius cards, Roboto Flex, Material Symbols, safe-area padding, and blue primary emphasis. Keep that direction, but formalize it.

- Brand mood: calm, focused, modern productivity
- Primary accent: Google-like blue
- Surface model: warm neutral backgrounds with layered translucent surfaces
- Shape language: rounded, never sharp; generous corners on cards and sheets
- Iconography: Material Symbols only
- Typography voice: neutral, legible, utilitarian, compact enough for task-heavy screens

## Token Architecture

Move the current loose `--app-*` variables toward a three-layer token model:

1. Primitive tokens: raw values
2. Semantic tokens: Material role aliases
3. Component tokens: per-component application

Recommended naming:

```css
/* primitives */
--md-ref-primary-40: #0b57d0;
--md-ref-neutral-98: #fdf8f6;
--md-ref-error-40: #b3261e;

/* semantic */
--md-sys-color-primary: var(--md-ref-primary-40);
--md-sys-color-surface: var(--md-ref-neutral-98);
--md-sys-color-error: var(--md-ref-error-40);

/* component */
--todo-auth-card-bg: var(--md-sys-color-surface-container-high);
--todo-task-card-radius: 1.25rem;
--todo-bottom-nav-height: 5rem;
```

Implementation rule: new component styles should consume semantic or component tokens, never hardcoded hex, spacing, or radius values.

## Typography

Use the full Material 3 type scale and map it consistently:

- `display-*`: reserved for onboarding and empty-state hero moments only
- `headline-large` and `headline-medium`: top app bar titles and auth card titles
- `title-large` and `title-medium`: section headings, bottom sheet titles, task detail headers
- `body-large` and `body-medium`: default form copy, task descriptions, settings rows
- `body-small`: metadata, due-date support text, tertiary content
- `label-large`: filled and outlined button labels
- `label-medium`: chips, segmented controls, badges
- `label-small`: counters, helper labels, tiny meta tags

Use `Roboto Flex` throughout. Keep line-height generous and preserve at least 48px interactive heights even when label text is small.

## Color System

The product should support light and dark themes with stable Material role mapping.

Core roles:

- Primary: main CTA, active nav item, focused field state, selected chips
- Secondary: supporting emphasis, tonal buttons, low-priority accents
- Tertiary: dashboard accents and non-destructive highlights
- Error: destructive actions, overdue state, inline validation
- Surface stack: background, surface, surface-container, surface-container-high, outline

Semantic product mapping:

- Low priority task: surface-variant
- Medium priority task: secondary
- High priority task: tertiary
- Urgent priority task: error
- Completed task: custom success token layered on surface
- Overdue task: error container + error text pairing

Use tonal layering and surface tint before relying on dramatic shadows. A small shadow is acceptable as a web fallback, but color and surface separation should do most of the work.

## Shape, Spacing, and Elevation

- Auth card radius: 28px
- Standard card radius: 20px
- Bottom sheet radius: 28px top corners
- Input radius: 16px
- Chip radius: full pill
- FAB radius: Material default large shape

Spacing should use a 4px base scale from 4 to 64. Compact screens should feel dense but not cramped; default content gaps should land around 12px, 16px, 20px, and 24px.

## Layout and Navigation

### Compact screens

- Primary navigation uses a bottom navigation bar with four destinations: Tasks, Search, Notifications, Profile.
- A centered or right-aligned FAB sits above the bar for task creation.
- The top app bar carries the current title plus contextual actions like search, filter, or delete.
- Forms and auth flows use full-screen single-card layouts.

### Medium screens

- Promote the bottom navigation to a rail when width allows or when landscape ergonomics make bottom reach worse.
- Task list and detail can move into a two-column master-detail layout.

### Large screens

- Use navigation rail plus persistent content columns.
- The dashboard and task detail views may become side-by-side surfaces rather than modal flows.

## Auth Flow Design

The auth experience must remain built on Laravel's built-in auth services, wrapped in Livewire screens rather than Breeze or Jetstream branding.

Auth screens should follow these rules:

- One centered full-screen card per route
- Large title, one-sentence supporting copy, then fields
- Outlined text fields with labels visible at rest
- Inline error or support text directly under the field
- One filled primary CTA per screen
- Secondary actions as text links below the form
- Password reset success uses a calm status banner, not a modal

Current repo note: the existing auth components already match the broad structure, but the final system should standardize spacing, field states, checkbox states, remember-me treatment, and helper text across all auth views.

## Core Component Rules

### Buttons

- Filled button: main submit or confirm action
- Filled tonal button: secondary but still important action
- Outlined button: alternative branch or filter trigger
- Text button: low-emphasis navigation or dismissive action
- Icon button: compact toolbar action only, always with an accessible label

### Text fields

- Prefer outlined fields for auth, search, task forms, and settings
- Always pair fields with labels
- Supporting text and error text occupy a fixed rhythm below the field
- Error state changes border, label, and support text together

### Task cards

- Show checkbox, title, due date, and priority immediately
- Secondary metadata may include category, tag pills, and subtask progress
- Completed tasks reduce emphasis but stay readable
- Swipe or reveal actions should never hide the primary status state

### Bottom sheets

- Use for create/edit flows, filter panels, and lightweight secondary actions
- Include drag handle, clear title, dismiss affordance, and safe-area bottom padding
- Do not overload sheets with multi-step wizard behavior unless explicitly an onboarding flow

### Feedback

- Toasts and snackbars appear above bottom navigation
- Destructive actions should support undo when feasible
- Progress indicators should be top-edge or inline, not modal blockers
- Offline state uses a persistent banner below the app bar

## Accessibility and Motion

Accessibility is a first-order design rule:

- Maintain minimum 48px touch targets
- Keep normal text contrast at 4.5:1 or better
- Use labels, icons, and text together for priority and status, not color alone
- Ensure keyboard order matches visual order
- Keep focus styles visible on every interactive element

Motion should stay informative, not decorative:

- Card entrance: subtle fade and upward settle
- FAB: scale entrance and state morph when a sheet is open
- Bottom sheet: decelerate in, accelerate out
- Task completion: short opacity and decoration transition
- Respect `prefers-reduced-motion`

## Repo Handoff

This design should map directly to the current codebase:

- `resources/css/app.css` becomes the design token and component-style source of truth
- `resources/views/layouts/app.blade.php` and `resources/views/layouts/auth.blade.php` should apply theme classes, safe-area variables, and consistent layout primitives
- `resources/views/livewire/auth/*.blade.php` should adopt the final auth field and CTA rules
- New shared primitives should be introduced before duplicating per-screen CSS

Recommended shared UI primitives:

- auth card
- outlined text field wrapper
- inline field message
- bottom sheet shell
- task card shell
- status chip
- toast stack
- empty state block

## References

Official sources reviewed for this spec:

- Google Material Web Buttons: https://material-web.dev/components/button/
- Google Material Web Text Field: https://material-web.dev/components/text-field/
- Google Material Web FAB: https://material-web.dev/components/fab/
- Google Material Web Icon Button: https://material-web.dev/components/icon-button/
- Android Developers, Material Design 3 in Compose: https://developer.android.com/develop/ui/compose/designsystems/material3
- Android Developers, Navigation bar: https://developer.android.com/develop/ui/compose/components/navigation-bar
- Android Developers, Navigation rail: https://developer.android.com/develop/ui/compose/components/navigation-rail
- Android Developers, Bottom sheets: https://developer.android.com/develop/ui/compose/components/bottom-sheets
- Android Developers, Accessibility API defaults: https://developer.android.com/develop/ui/compose/accessibility/api-defaults
- Android Developers, Make apps more accessible: https://developer.android.com/guide/topics/ui/accessibility/apps

This file is the design source of truth for upcoming UI work unless a later revision replaces it.
