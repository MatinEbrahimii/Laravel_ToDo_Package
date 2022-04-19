<?php

namespace MatinEbrahimii\ToDo\Facades\Repositories;

use Illuminate\Support\Facades\Facade;
use MatinEbrahimii\ToDo\Repositories\User\UserEloquentRepo;

class UserRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return UserEloquentRepo::class;
    }

    static function shouldProxyTo($class)
    {
        app()->singleton(self::getFacadeAccessor(), $class);
    }
}