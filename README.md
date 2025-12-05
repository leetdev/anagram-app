# Anagram Finder (PHP + React developer test assignment)

## Description

This is a demo application for finding anagrams for given words. Includes REST endpoints for:
- Fetching a word base to use for anagram search and saving it to the database
- Finding anagrams in the database for a given word

## Technology stack
- Laravel framework 12 for the backend API (using PHP 8.2+)
- PostgreSQL database
- React 19 for the frontend app (using Bun as the JS runtime and package manager)

## Getting started

### Using Docker Compose

### Prerequisites
Ensure you have Docker and Docker Compose installed. You can verify by running:

```bash
docker --version
docker compose version
```

If these commands do not return the versions, install Docker and Docker Compose using the official documentation: [Docker](https://docs.docker.com/get-docker/) and [Docker Compose](https://docs.docker.com/compose/install/).

### Clone the Repository

```bash
git clone https://github.com/leetdev/anagram-app.git
cd anagram-app
```

### Setting Up the Development Environment

1. Copy the .env.example file to .env and adjust any necessary environment variables:

```bash
cp .env.example .env
```

Hint: adjust the `UID` and `GID` variables in the `.env` file to match your user ID and group ID. You can find these by running `id -u` and `id -g` in the terminal.

Note: set the `NGINX_PORT` environment variable to change the port the app will be served from on the host machine. If you do that, you'll also have to adjust the `APP_URL` variable in `.env`.

2. Start the Docker Compose Services:

```bash
docker compose -f compose.dev.yaml up -d
```

3. Install Laravel Dependencies:

```bash
docker compose -f compose.dev.yaml exec workspace bash
composer install
bun install
bun run dev
```

4. Run Migrations:

```bash
docker compose -f compose.dev.yaml exec workspace php artisan migrate
```

5. Access the Application:

Open your browser and navigate to [http://localhost:8080](http://localhost:8080).
