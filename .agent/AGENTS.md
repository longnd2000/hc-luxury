# Homecare Luxury Theme — AI Agent Instructions

## Role
You are an AI developer working on the **Homecare Luxury** WordPress child theme (package: `Child_Theme`). You write production-quality PHP, SCSS, and HTML that follows the project's strict coding standards.

## Project Overview
- **Type**: WordPress Child Theme (Elementor-based)
- **Stack**: PHP 8+, WordPress 6.x, Elementor Pro, ACF Pro 6.2, SCSS, jQuery
- **Text Domain**: `child-theme`
- **CSS Prefix**: `lx_`
- **Function Prefix**: `child_theme_`

## Directory Structure
```
child-theme/
├── functions.php          # Entry point only (constants + module loader)
├── style.css              # Theme metadata
├── inc/                   # PHP modules (hooks, filters, CPTs)
│   ├── helpers.php        # Debug & utility functions (loaded first)
│   ├── enqueue.php        # CSS, JS, fonts
│   ├── elementor.php      # Elementor widget loader
│   ├── post-types.php     # Custom Post Types & Taxonomies
│   ├── acf.php            # ACF JSON sync settings
│   ├── query.php          # pre_get_posts modifications
│   └── template-tags.php  # Archive title, display helpers
├── components/            # Reusable PHP partials (post_card, event_card, ...)
├── widgets/               # Custom Elementor widgets
│   ├── index.php          # Widget autoloader
│   └── template/          # Widget template files
├── assets/
│   ├── css/               # Compiled CSS
│   ├── scss/              # Source SCSS (_style.scss, _ctf7.scss, main.scss)
│   └── js/                # JavaScript (main.js, vendor/)
├── acf-json/              # ACF field group JSON sync
├── form-ctf7/             # Contact Form 7 form configs
└── .agent/                # AI agent configuration
    ├── AGENTS.md           # This file — agent context & role
    └── workflows/          # Step-by-step procedures
```

## Mandatory Reading
Before writing ANY code, you MUST read and follow:
1. **`/project-rules`** workflow — All 10 sections of coding standards are mandatory.

## Key Principles
1. **Always check `/project-rules`** before any code change.
2. **New PHP logic** → place in the correct `/inc` module (Section 9).
3. **Repeated UI** → extract to `/components` (Section 8).
4. **Debug** → use `write_log()` only (Section 10).
5. **CSS** → `lx_` prefix, snake_case, no nesting, 4px grid (Sections 3–5).
6. **Never edit `functions.php`** for logic — only constants and `require_once`.
