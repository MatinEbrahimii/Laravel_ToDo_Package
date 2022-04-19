<?php

namespace MatinEbrahimii\ToDo\Models;

use Illuminate\Database\Eloquent\Model;

class Label extends Model
{    
    protected $guarded = ['id'];

    public function tasks()
    {
        return $this->belongsToMany(Task::class);
    }
}
