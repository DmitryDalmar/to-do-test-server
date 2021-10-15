## Setup

- docker-compose up -d
- docker-compose exec laravel.test composer install
- alias sail='bash vendor/bin/sail'
- sail up -d
- sail artisan migrate
- sail artisan db:seed
- sail artisan optimize:clear

## If you are setting up your project with laravel sail, the application will be available on the port specified in .env (APP_PORT)

## To get json response you need to add header: Accept:application/json

## Task urls
- GET: /api/task - get task list
- GET: /api/task/{id} - get current task
- POST: /api/task - {title: 'title', description: 'description'}, create task
- PUT: /api/task/{id} - update task
- DELETE: /api/task/{id} - delete task
