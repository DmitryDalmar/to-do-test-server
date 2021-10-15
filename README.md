## Setup

- alias sail='bash vendor/bin/sail'
- sail up -d
- sail composer install
- sail artisan migrate
- sail artisan db:seed
- sail artisan optimize:clear

## To get json response you need to add header: Accept:application/json

## Task urls
- GET: http://to-do.test/api/task - get task list
- GET: http://to-do.test/api/task/{id} - get current task
- POST: http://to-do.test/api/task - {title: 'title', description: 'description'}, create task
- PUT: http://to-do.test/api/task/{id} - update task
- DELETE: http://to-do.test/api/task/{id} - delete task
