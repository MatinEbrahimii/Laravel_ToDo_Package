<?php

namespace MatinEbrahimii\ToDo\Facades\Repositories;

use Illuminate\Support\Facades\Facade;
use MatinEbrahimii\ToDo\Repositories\Lable\LabelEloquentRepo;

class LabelRepository extends Facade
{
    protected static function getFacadeAccessor()
    {
        return LabelEloquentRepo::class;
    }

    static function shouldProxyTo($class)
    {
        app()->singleton(self::getFacadeAccessor(), $class);
    }
}
