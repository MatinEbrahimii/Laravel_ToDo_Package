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

Add auth middleware to App\Http\kernel.php

```
'auth' => \MatinEbrahimii\ToDo\Http\Middleware\Authenticate::class
```

# Postman Documentation Link 
https://documenter.getpostman.com/view/6655749/Uyr7Jyvh


