<?php

namespace MatinEbrahimii\ToDo\Repositories\Lable;

use MatinEbrahimii\ToDo\Models\Label;
use Imanghafoori\Helpers\Nullable;

class LabelEloquentRepo
{
    public function all()
    {
        $labels = Label::whereHas('tasks', function ($query) {
            $query->where('user_id', auth()->id());
        })->get();

        optional($labels)->map(function ($label) {
            optional($label)->setVisible(['id', 'title', 'description', 'tasks']);
            optional(optional($label)->tasks)->map(function ($task) {
                $task->setVisible(['id', 'title', 'description']);
            });
        });

        return $labels;
    }

    public function findOne($label_id)
    {
        $label = Label::whereHas('tasks', function ($query) {
            $query->where('user_id', auth()->id());
        })->find($label_id);

        optional($label)->setVisible(['id', 'title', 'description', 'tasks']);
        optional(optional($label)->tasks)->map(function ($task) {
            $task->setVisible(['id', 'title', 'description']);
        });

        return nullable($label);
    }

    public function store($data): Nullable
    {
        try {
            $label = Label::create($data);
        } catch (\Exception $exception) {
            return nullable(null);
        }

        if (!$label->exists)
            return nullable(null);

        return nullable($label);
    }

    public function update($label, $data)
    {
        try {
            $is_updated = $label->update($data);
        } catch (\Exception $exception) {
            return nullable(null);
        }

        if (!$is_updated)
            return nullable(null);

        return nullable($label);
    }
}
