<?php

namespace MatinEbrahimii\ToDo\Providers;

use MatinEbrahimii\ToDo\Facades\ResponderFacade;
use MatinEbrahimii\ToDo\Facades\NotificationFacade;
use Illuminate\Support\Facades\Route;
use MatinEbrahimii\ToDo\Http\Responses\JsonResponses;
use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use MatinEbrahimii\ToDo\Notifications\TaskSendNotifDefault;
use MatinEbrahimii\ToDo\Repositories\Task\TaskEloquentRepo;
use MatinEbrahimii\ToDo\Facades\Repositories\TaskRepository;
use MatinEbrahimii\ToDo\Facades\Repositories\LabelRepository;
use MatinEbrahimii\ToDo\Notifications\FakeNotificationSender;
use MatinEbrahimii\ToDo\Repositories\Lable\LabelEloquentRepo;

class ToDoServiceProvider extends ServiceProvider
{
    private $namespace = 'MatinEbrahimii\ToDo\Http\Controllers';

    public function register()
    {
        // $this->mergeConfigFrom(__DIR__.'/config/tokenized_login.php', 'tokenized_login');


        if (app()->runningUnitTests()) {
            $notification = FakeNotificationSender::class;
        } else {
            $notification = TaskSendNotifDefault::class;
        }

        ResponderFacade::shouldProxyTo(JsonResponses::class);
        TaskRepository::shouldProxyTo(TaskEloquentRepo::class);
        LabelRepository::shouldProxyTo(LabelEloquentRepo::class);
        NotificationFacade::shouldProxyTo($notification);
    }

    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            $this->defineRoutes();
        }

        $base_todo_address =  strstr(__DIR__, DIRECTORY_SEPARATOR . 'Providers', true);

        $this->loadMigrationsFrom($base_todo_address . DIRECTORY_SEPARATOR . 'database' . DIRECTORY_SEPARATOR . 'migrations');

        // $this->registerEloquentFactoriesFrom($base_todo_address . '/database/factories');
    }

    private function defineRoutes()
    {
        $base_todo_address =  strstr(__DIR__, DIRECTORY_SEPARATOR . 'Providers', true);

        Route::prefix('api')
            ->middleware('api')
            ->namespace($this->namespace)
            ->group($base_todo_address . DIRECTORY_SEPARATOR . 'routes.php');
    }

    protected function registerEloquentFactoriesFrom($path)
    {
        $this->app->make(Factory::class)->load($path);
    }
}
