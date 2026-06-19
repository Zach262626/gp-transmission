# Project Name

<p align="center">
  <img src="public/img/Logo-800p-sameCrlor.png" alt="Project Logo" width="400">
</p>

A brief description of what your project does and its main purpose.

## Requirements

Before you get started, make sure you have the following installed on your machine:

- **Git** - For cloning the repository
- **PHP 8.1+** - Laravel's language requirement
- **Composer** - PHP dependency manager
- **Node.js & npm** - For frontend asset compilation

You can run this project in **one of two ways** — pick whichever you prefer:

- **Docker (Laravel Sail)** — needs **Docker**, plus **WSL 2** on Windows. Self-contained PHP + MySQL + phpMyAdmin in containers. Note: on Windows the code is bind-mounted into the container, which makes Artisan commands and migrations noticeably slower.
- **Local (native)** — needs a local **PHP** and **MySQL** server. On Windows this is typically **WAMP**/Laragon; on macOS Herd/Valet. Faster than Docker on Windows.

The shared steps below apply to both. Then follow **either** the Docker path **or** the Local path.

## Installation

Follow these steps to get the project running locally:

### 1. Clone the Repository
```bash
git clone <your-repository-url>
cd <project-directory>
```

### 2. Install PHP Dependencies
```bash
composer install
```

### 3. Install Node Dependencies
```bash
npm install
```

### 4. Environment Setup
Copy the example environment file and create your local configuration:
```bash
cp .env.example .env
```

Then edit the `.env` file and configure:
- Database credentials, App name and URL, and any other environment-specific variables
- **`DB_HOST` depends on which setup you use** (this is the most common source of "migrate is slow / can't connect"):
  - **Docker:** `DB_HOST=mysql` (the Sail service name)
  - **Local/WAMP:** `DB_HOST=127.0.0.1` (use `127.0.0.1`, not `localhost` — on Windows `localhost` is slow to resolve)

### 5. Build Frontend Assets
```bash
npm run build
```

For development with hot reload, you can use:
```bash
npm run dev
```

### 6. Finish setup — choose your path

#### Option A — Docker (Laravel Sail)

Make sure `DB_HOST=mysql` in your `.env`, then:

```bash
# Start the containers (first run downloads/builds images)
./vendor/bin/sail up -d

# Generate the app key, run migrations (add --seed for test data)
./vendor/bin/sail artisan key:generate
./vendor/bin/sail artisan migrate --seed
```

Your app is now running at `http://localhost` (phpMyAdmin at `http://localhost:8081`). Verify containers with `./vendor/bin/sail ps`.

#### Option B — Local (WAMP / native PHP & MySQL)

Make sure your local MySQL server is running and the database exists (create it in phpMyAdmin/CLI if not). Set `DB_HOST=127.0.0.1` in your `.env`, then run Artisan directly with `php`:

```bash
# Create the database (skip if it already exists)
# e.g. in MySQL:  CREATE DATABASE gp_website;

php artisan key:generate
php artisan migrate --seed
php artisan serve   # serves at http://localhost:8000
```

When using WAMP, you can also just place the project under `www/` and browse to it via Apache instead of `php artisan serve`.

## Useful Commands

Once the project is set up, here are some common commands. The Sail (`./vendor/bin/sail ...`) versions run inside Docker; the plain `php`/`npm` versions run locally.

```bash
# Docker (Laravel Sail)          # Local (native)
./vendor/bin/sail up -d          # (nothing — your local server is already running)
./vendor/bin/sail stop           # (nothing)
./vendor/bin/sail artisan <cmd>  php artisan <cmd>
./vendor/bin/sail tinker         php artisan tinker
./vendor/bin/sail test           php artisan test
./vendor/bin/sail npm run dev    npm run dev
```

## Troubleshooting

**Docker won't start?**
- Make sure Docker Desktop is running
- On Windows, verify WSL 2 is installed and enabled
- Try rebuilding: `./vendor/bin/sail build`

**Port conflicts?**
- If port 80 is already in use, you can specify a different port in your `.env` file

**Migrations slow or "could not connect to database"?**
- Almost always a `DB_HOST` mismatch. Use `DB_HOST=mysql` for **Docker**, or `DB_HOST=127.0.0.1` for **local/WAMP**.
- After changing `.env`, clear the cached config: `php artisan config:clear` (or `./vendor/bin/sail artisan config:clear`).
- Make sure the target MySQL is actually running (WAMP tray icon green, or `./vendor/bin/sail ps` for Docker).

**Database migration errors?**
- Check your `.env` database configuration matches your chosen setup (Docker vs local)
- Run `php artisan migrate:refresh --seed` (or the `sail` equivalent) to reset and reseed

## Project Structure

```
├── app/                 # Application logic
├── database/            # Migrations and seeders
├── public/              # Public assets and images
├── resources/           # Views and frontend assets
├── routes/              # Application routes
├── storage/             # Logs and file uploads
└── tests/               # Unit and feature tests
```
