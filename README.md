# Backend for ToDo SPA

API on Laravel 9 for To Do list application

> Backend for https://github.com/kolimbet/todo-spa-frontend

## API supports:

- authorization and user logout
- registration of new users with verification of the uniqueness of email and user name
- changing the user's password
- uploading and deleting user images, as well as displaying a list of all images uploaded by the user
- setting the user's avatar from the list of images uploaded by him
- actions with user tasks: list output, counters of completed and unfulfilled tasks, adding and deleting tasks, as well as completing a task and changing the task description

## Installation

Clone this repository to your server:

```
git clone https://github.com/kolimbet/todo-spa-back.git todo-app.back
```

Install the necessary composer packages:

```
composer install
```

Rename .env.example to .env and enter APP_URL and your DB settings in it.

Generate key and link in /public to the storage:

```
php artisan key:generate
php artisan storage:link
```

Generate a database with seeds:

```
php artisan migrate --seed
```

Set rights:

```
sudo chown www-data:www-data -R storage/logs
sudo chmod -R 777 storage
sudo chmod -R 777 bootstrap/cache
```

## Testing

I used Postman to test the API. The file with the query collection settings is located in the /docs folder. Change the domain variable to the URL you set and you can use it.
