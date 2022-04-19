<?php

namespace MatinEbrahimii\ToDo\Repositories\Task;

use MatinEbrahimii\ToDo\Models\Task;
use Illuminate\Support\Facades\DB;
use Imanghafoori\Helpers\Nullable;

class TaskEloquentRepo
{
    public function all()
    {
        $tasks = Task::where('user_id', auth()->id())->get();

        optional($tasks)->map(function ($task) {
            optional($task)->setVisible(['id', 'title', 'description', 'status', 'labels']);

            optional(optional($task)->labels)->map(function ($label) {
                optional($label)->setVisible(['id', 'title', 'description']);
            });
        });

        return $tasks;
    }

    public function findOne($task_id)
    {
        $task = Task::where('user_id', auth()->id())->find($task_id);

        optional($task)->setVisible(['id', 'title', 'description', 'status', 'labels']);
        optional(optional($task)->labels)->map(function ($label) {
            optional($label)->setVisible(['id', 'title', 'description']);
        });

        return nullable($task);
    }

    public function store($data): Nullable
    {
        DB::beginTransaction();
        try {

            $data['status'] = 'pending';

            if (!isset($data['user_id']) or $data['user_id'] == null) {
                $data['user_id'] = auth()->id();
            }

            $task = Task::create($data);

            if (array_key_exists('labels', $data)) {
                $task->labels()->attach($data['labels']);
            }

            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
            return nullable(null);
        }

        if (!$task->exists)
            return nullable(null);

        return nullable($task);
    }

    public function update($task, $data)
    {
        try {
            $is_updated = $task->update($data);
        } catch (\Exception $exception) {
            return nullable(null);
        }

        if (!$is_updated)
            return nullable(null);

        return nullable($task);
    }

    public function addLabels($task, $labels): Nullable
    {
        try {

            if (!empty($labels))
                $task->labels()->createMany($labels);
        } catch (\Exception $exception) {
            return nullable(null);
        }

        if (!$task->exists)
            return nullable(null);

        return nullable($task);
    }

    public function assignLabelsWithId($task, $labels_ids): Nullable
    {
        try {

            $task->labels()->attach($labels_ids);
        } catch (\Exception $exception) {
            return nullable(null);
        }

        if (!$task->exists)
            return nullable(null);

        return nullable($task);
    }
}
