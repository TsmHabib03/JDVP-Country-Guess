# Country Explorer - AI Coding Instructions

## Project Overview
A PHP/MySQL geography web application for searching country information (name, capital, flag). Runs on XAMPP (Apache + MariaDB).

## Architecture

```
index.php          # Single-page app: UI + search logic (no MVC separation)
db.php             # Database connection (mysqli)
styles/styles.css  # All styling (glassmorphism theme)
flags/             # Static flag images (Country_Name.png format)
country_db.sql     # Database schema + seed data (317 lines, 250+ countries)
```

## Database Schema
- **Database**: `country_db`
- **Table**: `countries` (`id`, `country_name`, `capital`, `flag`)
- **Flag paths**: Relative paths like `./flags/Country_Name.png` (underscores for spaces)

## Development Setup
1. Import `country_db.sql` via phpMyAdmin
2. Update credentials in `db.php` if needed (default: `root`/`localhost`)
3. Access via `http://localhost/country/`

## Code Patterns

### Database Queries
Uses raw mysqli with string interpolation (legacy pattern):
```php
$query = "SELECT * FROM countries WHERE country_name LIKE '%$country%'";
$result = mysqli_query($conn, $query);
```
> ⚠️ **Security Note**: Current code is vulnerable to SQL injection. When modifying, consider using prepared statements.

### Frontend Structure
- **Fonts**: Google Fonts (Playfair Display for headings, Inter for body)
- **Theme**: Dark mode with glassmorphism, gold/terracotta accents
- **Result cards**: `.passport-entry` class with flex layout

### CSS Conventions
- Uses CSS custom properties sparingly; colors are hardcoded
- Key color palette: `#0f172a` (ocean blue), `#cca43b` (gold), `#e07a5f` (terracotta)
- Mobile breakpoint: `480px`

## When Adding Features
- New country data: Add to `countries` table, place flag PNG in `flags/` with underscore naming
- New pages: Include `db.php` at top, link `styles/styles.css`
- Maintain the "premium geography/travel" visual theme
