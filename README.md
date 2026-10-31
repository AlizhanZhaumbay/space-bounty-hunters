# Space Bounty Hunters API

A REST API for space bounty hunters. It has a list of wanted criminals and a journal of hunt attempts.

Built with Laravel 13 and PostgreSQL 17. Runs in Docker Compose (`app` + `db`).

## Setup

```bash
cp .env.example .env
# Put a password in DB_PASSWORD in .env.
# Make an APP_KEY:
docker run --rm php:8.4-cli-alpine php -r 'echo "base64:".base64_encode(random_bytes(32)).PHP_EOL;'
# Copy the output into APP_KEY in .env.
```

## Run and fill the database

```bash
docker compose up -d --build
docker compose exec app php artisan db:seed --force
```

Migrations run when the app starts. The seed adds 6 criminals and 12 hunt logs.

To start the database from zero: `docker compose exec app php artisan migrate:fresh --seed --force`

The API runs at `http://localhost:8000`. You can change the port with `APP_PORT`.

## Database

- `wanted_criminals`: `id`, `name` (can be empty), `nickname`, `reward`, `difficulty` (1–10), `armed`, `has_crew`, `escape_master`.
  Last known location: `latitude` and `longitude`, or a text note in `location_note`. All three can be empty.
- `hunt_logs`: `id`, `criminal_id` (links to `wanted_criminals.id`), `success`, `notes`, `created_at`.
  The server sets `created_at`. The client cannot send it.
- One criminal can have many hunt logs.

## API

| Method | Path                    | What it does                       |
|--------|-------------------------|------------------------------------|
| GET    | `/api/criminals/`       | List criminals                     |
| GET    | `/api/criminals/{id}/`  | Get one criminal                   |
| GET    | `/api/hunts/`           | List hunt logs                     |
| GET    | `/api/hunts/{id}/`      | Get one hunt log                   |
| POST   | `/api/hunts/`           | Add a hunt log                     |
| PATCH  | `/api/hunts/{id}/`      | Change `success` and/or `notes`    |
| DELETE | `/api/hunts/{id}/`      | Delete a hunt log                  |

Filters for `/api/criminals/` (you can use them together):

- `min_reward`, `max_reward`: reward range
- `armed`, `has_crew`, `escape_master`: `true`/`false` (or `1`/`0`)
- `sort`: `reward` (low to high) or `-reward` (high to low)

Example: `GET /api/criminals/?min_reward=5000&armed=true&sort=-reward`

Filter for `/api/hunts/`: `criminal_id`. Example: `GET /api/hunts/?criminal_id=5`

Body for `POST /api/hunts/`:

```json
{
  "criminal_id": 3,
  "success": false,
  "notes": "Target escaped through an asteroid field."
}
```

Status codes:

- `200`: read or update OK
- `201`: created
- `204`: deleted
- `404`: id not found
- `422`: bad data or bad filter (also when `criminal_id` does not exist)

## Postman

Import `postman/space-bounty-hunters.postman_collection.json`. Run it on a freshly seeded database.
`base_url` is `http://localhost:8000` by default.
