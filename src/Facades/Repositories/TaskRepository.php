<?php

namespace MatinEbrahimii\ToDo\Facades\Repositories;

use Illuminate\Support\Facades\Facade;
use MatinEbrahimii\ToDo\Repositories\Task\TaskEloquentRepo;

class TaskRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return TaskEloquentRepo::class;
    }
    
    static function shouldProxyTo($class)
    {
        app()->singleton(self::getFacadeAccessor(), $class);
    }
}