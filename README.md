# ToDo_Package
A Package for add Todo functionality to main laravel project

# Installation
```
composer require matinebrahimi/laravel-todo-app
```
Then run migrate command:

```
php artisan migrate
```

Update auth middleware in App\Http\kernel.php in routeMiddleware array

```
'auth' => \MatinEbrahimii\ToDo\Http\Middleware\Authenticate::class
```

#### * important point: /api/todo/tasks/{id}/changeStatus end-point will not work until the email server is configured

# Postman api Documentation Link 
https://documenter.getpostman.com/view/6655749/Uyr7Jyvh


