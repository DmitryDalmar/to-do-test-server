## Setup
- composer install
- alias sail='bash vendor/bin/sail'
- sail up -d
- sail composer update
- sail artisan migrate
- sail artisan db:seed
- sail artisan optimize:clear

## If you are setting up your project with laravel sail, the application will be available on the port specified in .env (APP_PORT)

## To get json response you need to add header: Accept:application/json

## Login
- POST: /api/login - {email: 'email', password: 'password'}.
## Response. To get auth routes, need to send header: {Authorization:Bearer $token-value-in-response}
```json
{
    "token": "4|WyXPwe85nC842VFemfY4Yc7tbRHaS9wsmSnlAfYU",
    "user": {
      "id": 32,
      "name": "Theron Blick",
      "email": "lkozey@example.net",
      "email_verified_at": "2021-10-15T12:09:32.000000Z",
      "created_at": "2021-10-15T12:09:33.000000Z",
      "updated_at": "2021-10-15T12:09:33.000000Z"
    }
}
```

## Register
POST: /api/register - 
```json
{
  "email": "lkozey32@example.net"
  "password": "12345678"
  "password_confirmation": "12345678"
  "name": "kozey"
}
```
## Response
```json
{
    "token": "5|jlrC9Xzuc0XnR5b8yM1VrZHx2sFYso8GAm045kB0",
    "user": {
        "email": "lkozey32@example.net",
        "name": "kozey",
        "updated_at": "2021-10-15T12:42:51.000000Z",
        "created_at": "2021-10-15T12:42:51.000000Z",
        "id": 37,
        "email_verified_at": "2021-10-15T12:42:51.000000Z"
    }
}
```

## Get Auth User. Header {Authorization:Bearer $token-value-in-login-response}
GET: /api/user.
## Response
```json
{
    "id": 37,
    "name": "kozey",
    "email": "lkozey32@example.net",
    "email_verified_at": "2021-10-15T12:42:51.000000Z",
    "created_at": "2021-10-15T12:42:51.000000Z",
    "updated_at": "2021-10-15T12:42:51.000000Z"
}
```

## Logout. Header {Authorization:Bearer $token-value-in-login-response}
- POST: /api/logout.

## Response
```json
{
    "message": "logout"
}
```

## Task urls
- GET: /api/task - get task list
- GET: /api/task/{id} - get current task
- POST: /api/task - {title: 'title', description: 'description'}, create task
- PUT: /api/task/{id} - update task
- DELETE: /api/task/{id} - delete task
