# Homecare Luxury Theme — AI Agent Instructions

## Role
You are an AI developer working on the **Homecare Luxury** WordPress child theme (package: `Child_Theme`). You write production-quality PHP, SCSS, and HTML that follows the project's strict coding standards.

## Project Overview
- **Type**: WordPress Child Theme (Elementor-based)
- **Stack**: PHP 8+, WordPress 6.x, Elementor Pro, ACF Pro 6.2, SCSS, jQuery
- **Text Domain**: `child-theme`
- **CSS Prefix**: `lx_`
- **Function Prefix**: `child_theme_`

## Directory Map
```
child-theme/
├── functions.php              # Entry point only (constants + module loader)
├── style.css                  # Theme metadata
├── inc/                       # PHP modules (hooks, filters, CPTs)
│   ├── helpers.php            # Debug & utility functions (loaded first)
│   ├── enqueue.php            # CSS, JS, fonts
│   ├── elementor.php          # Elementor widget loader
│   ├── post-types.php         # Custom Post Types & Taxonomies
│   ├── acf.php                # ACF JSON sync settings
│   ├── query.php              # pre_get_posts modifications
│   └── template-tags.php      # Archive title, display helpers
├── components/                # Reusable PHP partials
├── widgets/                   # Custom Elementor widgets
│   ├── index.php              # Widget autoloader & registration
│   └── template/              # Widget template files
├── assets/
│   ├── css/                   # Compiled CSS
│   ├── scss/                  # Source SCSS (_style.scss, _ctf7.scss, main.scss)
│   └── js/                    # JavaScript (main.js, vendor/)
├── acf-json/                  # ACF field group JSON sync
├── form-ctf7/                 # Contact Form 7 form configs
└── .agent/                    # AI agent configuration
    ├── AGENT.md               # This file
    ├── rules/                 # Coding standards (read before ANY code change)
    ├── context/               # Project state documentation
    └── workflows/             # Step-by-step procedures
```

## Mandatory Rules
Before writing ANY code, read the relevant rule files in `.agent/rules/`:

| File | When to read |
|---|---|
| `rules/php.md` | Writing PHP, adding hooks/filters, creating `/inc` modules |
| `rules/css.md` | Writing CSS/SCSS, spacing, typography, class naming |
| `rules/acf.md` | Working with ACF fields, date formats |
| `rules/templates.md` | Creating/modifying templates, extracting components |
| `rules/frontend.md` | Data handling, images, icons, CF7 forms |
| `rules/elementor.md` | Creating Elementor widgets, specificity issues |

## Context Files
Check `.agent/context/` to understand existing project state:

| File | Contains |
|---|---|
| `context/post-types.md` | Registered CPTs & their ACF fields |
| `context/acf-fields.md` | All ACF field groups, keys, types |
| `context/components.md` | Reusable components registry & data contracts |
| `context/widgets.md` | Custom Elementor widgets registry |
| `context/forms.md` | Contact Form 7 forms |

## Available Workflows
Use `/slash-command` to trigger:

| Command | Description |
|---|---|
| `/create-component` | Create a new reusable component in `/components` |
| `/create-widget` | Create a new custom Elementor widget |
| `/add-inc-module` | Add a new PHP module in `/inc` |
| `/debug` | Debug PHP code using `write_log()` |

## Key Principles
1. **Always check rules** before any code change.
2. **New PHP logic** → place in the correct `/inc` module (`rules/php.md`).
3. **Repeated UI** → extract to `/components` (`rules/templates.md`).
4. **Debug** → use `write_log()` only (`rules/php.md`).
5. **CSS** → `lx_` prefix, snake_case, no nesting, 4px grid (`rules/css.md`).
6. **Never edit `functions.php`** for logic — only constants and `require_once`.
7. **Update context files** when adding CPTs, ACF fields, components, or widgets.
