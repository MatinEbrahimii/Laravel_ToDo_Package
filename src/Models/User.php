<?php

namespace MatinEbrahimii\ToDo\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;


class User extends Authenticatable
{
    use Notifiable;

    protected $guarded = ['id'];

    public function tasks()
    {
        $this->hadMany(Tasks::class);
    }
}
