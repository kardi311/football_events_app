Before tests run

bin/console --env=test doctrine:database:create
bin/console --env=test doctrine:migrations:migrate -q 
