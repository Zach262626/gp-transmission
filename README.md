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
- **Docker** - For running the application with Laravel Sail
- **WSL 2** (Windows only) - Windows Subsystem for Linux for Docker support

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
- Database credentials (if needed for local testing)
- App name and URL
- Any other environment-specific variables

### 5. Build Frontend Assets
```bash
npm run build
```

For development with hot reload, you can use:
```bash
npm run dev
```

### 6. Start Docker & Laravel Sail
```bash
./vendor/bin/sail up -d
```

This command starts the Docker containers in the background. On first run, it will download and build the necessary images.

### 7. Generate Application Key
```bash
./vendor/bin/sail artisan key:generate
```

### 8. Run Database Migrations
```bash
./vendor/bin/sail artisan migrate
```

If you have seeders to populate the database with test data:
```bash
./vendor/bin/sail artisan migrate:seed
```

### 9. Verify Installation
Your application should now be running at `http://localhost`. You can verify Docker containers are running with:
```bash
./vendor/bin/sail ps
```

## Useful Commands

Once the project is set up, here are some common commands you might need:

```bash
# Start the Docker environment
./vendor/bin/sail up -d

# Stop the Docker environment
./vendor/bin/sail stop

# View container logs
./vendor/bin/sail logs

# Run Artisan commands
./vendor/bin/sail artisan <command>

# Access the application shell
./vendor/bin/sail tinker

# Run tests
./vendor/bin/sail test
```

## Troubleshooting

**Docker won't start?**
- Make sure Docker Desktop is running
- On Windows, verify WSL 2 is installed and enabled
- Try rebuilding: `./vendor/bin/sail build`

**Port conflicts?**
- If port 80 is already in use, you can specify a different port in your `.env` file

**Database migration errors?**
- Check your `.env` database configuration matches the Docker setup
- Run `./vendor/bin/sail artisan migrate:refresh --seed` to reset and reseed

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
