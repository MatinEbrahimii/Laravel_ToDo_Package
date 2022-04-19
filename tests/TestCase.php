<?php

namespace MatinEbrahimii\ToDo;

use MatinEbrahimii\ToDo\Providers\ToDoServiceProvider;

abstract class TestCase extends \Orchestra\Testbench\TestCase
{
    protected function getPackageProviders($app)
    {
        return [ToDoServiceProvider::class];
    }
}
