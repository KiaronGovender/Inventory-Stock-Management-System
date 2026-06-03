# Inventory Stock Management System

A Laravel and Docker inventory system using Blade views for the frontend.

## Features

- User registration, login, and logout
- Dashboard with product, category, stock, and low-stock statistics
- Product CRUD with category, SKU, stock, threshold, price, and status fields
- Category CRUD with product counts
- Stock in/out tracking with movement history
- Low-stock alerts
- Search and filtering for products, categories, and stock movement
- Seeded demo inventory
- Feature tests for authentication, CRUD, dashboard alerts, and stock updates

## Tech Stack

- Laravel 13
- Blade and Tailwind CSS
- MySQL through Laravel Sail Docker
- Pest for tests

## Docker Setup

Copy the environment file and start Sail:

```bash
cp .env.example .env
composer install
php artisan key:generate
./vendor/bin/sail up -d
./vendor/bin/sail artisan migrate --seed
./vendor/bin/sail npm install
./vendor/bin/sail npm run dev
```

On Windows PowerShell, use:

```powershell
copy .env.example .env
composer install
php artisan key:generate
vendor\bin\sail up -d
vendor\bin\sail artisan migrate --seed
vendor\bin\sail npm install
vendor\bin\sail npm run dev
```

Open the app at `http://localhost`.

## Demo Login

After seeding:

- Email: `admin@example.com`
- Password: `password`

## Tests

```bash
php artisan test
```

The test suite uses in-memory SQLite, so it does not require Docker or MySQL.
