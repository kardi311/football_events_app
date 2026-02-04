# Football Events Application

## Installation and Setup

1. `git clone git@github.com:kardi311/football_events_app.git`
2. Inside project directory run `docker compose up -d`
3. Install dependencies `docker exec -it football_events_app-php-1 composer install`
4. Run migrations `docker exec -it football_events_app-php-1 bin/console doctrine:migrations:migrate -q`


3. The application will be available at: `http://localhost:8000`

## Usage

### Foul Event

Send a POST request with a foul event:

```bash
curl -X POST http://localhost:8000/event \
  -H "Content-Type: application/json" \
  -d '{"type": "foul", "player": "William Saliba", "team_id": "arsenal", "match_id": "m1", "minute": 45, "second": 34}'
```

### Example Response

Both events return a similar response structure:

```json
{
  "status": "success",
  "message": "Event saved successfully",
  "event": {
    "type": "foul",
    "timestamp": 1729599123,
    "data": {
      "type": "foul",
      "player": "William Saliba",
      "team_id": "arsenal",
      "match_id": "m1",
      "minute": 45,
      "second": 34
    }
  }
}
```

### Statistics Endpoint

Get team statistics for a specific match:

```bash
curl "http://localhost:8000/statistics?match_id=m1&team_id=arsenal"
```

Get all team statistics for a match:

```bash
curl "http://localhost:8000/statistics?match_id=m1"
```

Example response:
```json
{
  "match_id": "m1",
  "team_id": "arsenal",
  "statistics": {
    "fouls": 2
  }
}
```

Foul events automatically update team statistics (fouls counter) for the specified team in the given match.

## Tests
1. Run `docker exec -it football_events_app-php-1 bin/console --env=test doctrine:database:create`
2. Run `docker exec -it football_events_app-php-1 bin/console doctrine:migrations:migrate --env=test -q`
3. Run `docker exec -it football_events_app-php-1 make test`
