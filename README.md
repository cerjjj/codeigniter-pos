# Storefront POS

Storefront POS is a complete CodeIgniter 4 point-of-sale system for managing products, customers, staff accounts, inventory, and sales. It implements the IT0049 midterm project requirements with authenticated management pages, validated image uploads, hashed passwords, transaction-safe inventory updates, migrations, seed data, and automated tests.

## Features

- Secure staff login, logout, session regeneration, CSRF protection, and route filters
- Product list, add, edit, archive, restore, stock tracking, and prepared image uploads
- Customer full CRUD with preserved sales history after deletion
- Staff account CRUD with avatar uploads, password hashing, and account archiving
- Sale recording with optional customer, calculated total, atomic stock deduction, and overselling protection
- Sales history with product, customer, staff, quantity, total, and timestamp
- Responsive operations dashboard with revenue, transaction counts, recent sales, and low-stock alerts
- SQLite zero-configuration default plus MySQL/XAMPP configuration and schema export

## Requirements

- PHP 8.2 or newer
- Composer 2
- PHP extensions: `intl`, `mbstring`, `json`, `sqlite3` (default), and `gd` (image preparation)
- `mysqli` instead of `sqlite3` when using MySQL

## Local setup

```powershell
composer install
Copy-Item .env.example .env
php -d extension=sqlite3 spark migrate
php -d extension=sqlite3 spark db:seed PosSeeder
php -d extension=sqlite3 -d extension=gd spark serve
```

Open `http://127.0.0.1:8080` and sign in with:

- Username: `admin`
- Password: `Admin123!`

Change the seeded password after your first login when preparing a real deployment.

For XAMPP, you may instead enable `extension=sqlite3` and `extension=gd` in `C:\xampp\php\php.ini`, then use the shorter `php spark ...` commands. Restart Apache after changing `php.ini`.

## XAMPP and MySQL setup

1. Create a database named `storefront_pos` in phpMyAdmin, or import `database/schema.mysql.sql`.
2. Copy `.env.example` to `.env`.
3. Uncomment the MySQL settings in `.env` and update the username and password.
4. If you imported the SQL schema, run `php spark db:seed PosSeeder`. Otherwise, run `php spark migrate` and then the seeder.
5. Configure Apache so the document root points to this project's `public` directory. Never expose the project root directly.

## Tests

```powershell
php -d extension=sqlite3 vendor/bin/phpunit -c phpunit.dist.xml
```

The database tests use an isolated in-memory SQLite database. The sale workflow tests verify that a transaction reduces inventory correctly and that an oversized sale is rejected without changing stock.

## Deployment checklist

- Set `CI_ENVIRONMENT = production` and configure the deployed `app.baseURL`.
- Point the web server document root to `public`.
- Configure production database credentials through environment variables.
- Ensure `writable` and `public/uploads` are writable by the web server.
- Run `composer install --no-dev --optimize-autoloader`, `php spark migrate`, and the seeder only when demo data is appropriate.
- Replace the demo administrator password and enable HTTPS.
- Commit the project to GitHub, then submit the repository URL and hosted application URL required by the brief.

## Project structure

- `app/Controllers` contains authentication, dashboard, CRUD, and sales controllers.
- `app/Models` contains the four database models.
- `app/Services/SaleService.php` owns the inventory-safe sales transaction.
- `app/Database/Migrations` and `app/Database/Seeds` reproduce the database.
- `app/Views` contains the responsive interface.
- `database/schema.mysql.sql` is an optional MySQL schema export.
- `tests/database/SaleServiceTest.php` covers the critical inventory workflow.
