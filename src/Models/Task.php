<?php

namespace MatinEbrahimii\ToDo\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{    
    protected $guarded = ['id'];

    public function labels()
    {
        return $this->belongsToMany(Label::class);
    }
}
