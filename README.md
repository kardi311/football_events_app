# Football Events Application

## Installation and Setup

1. `git clone git@github.com:kardi311/football_events_app.git`
2. Inside project directory run `docker compose up -d`
3. Install dependencies `docker exec -it football_events_app-php-1 composer install`
4. Run migrations `docker exec -it football_events_app-php-1 bin/console doctrine:migrations:migrate -q`

## Tests
1. Run `docker exec -it football_events_app-php-1 bin/console --env=test doctrine:database:create`
2. Run `docker exec -it football_events_app-php-1 bin/console doctrine:migrations:migrate --env=test -q`
3. Run `docker exec -it football_events_app-php-1 make test`
