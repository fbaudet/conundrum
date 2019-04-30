SYMFONY=php bin/console

db:
	${SYMFONY} doctrine:database:drop --force
	${SYMFONY} doctrine:database:create
	${SYMFONY} doctrine:migrations:migrate --no-interaction

fixtures:
	${SYMFONY} doctrine:fixtures:load --no-interaction

test:
	./bin/phpunit
