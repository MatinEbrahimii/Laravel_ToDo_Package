<?php

namespace MatinEbrahimii\ToDo\Http\Controllers;

use MatinEbrahimii\ToDo\Jobs\SendTaskNotifJob;
use MatinEbrahimii\ToDo\Facades\ResponderFacade;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use MatinEbrahimii\ToDo\Facades\NotificationFacade;
use MatinEbrahimii\ToDo\Http\Requests\Task\AddLabelRequest;
use MatinEbrahimii\ToDo\Facades\Repositories\TaskRepository;
use MatinEbrahimii\ToDo\Http\Requests\Task\TaskStoreRequest;
use MatinEbrahimii\ToDo\Http\Requests\Task\TaskUpdateRequest;
use MatinEbrahimii\ToDo\Http\Requests\Task\AssignLabelRequest;
use MatinEbrahimii\ToDo\Http\Requests\Task\TaskChangeStatusRequest;

class TaskController extends Controller
{
    public function index()
    {
        $tasks = TaskRepository::all();

        return  ResponderFacade::send('tasks', $tasks);
    }

    public function show($id)
    {
        $task = TaskRepository::findOne($id);

        $task = $task->getOrSend(
            [ResponderFacade::class, 'notFound']
        );

        return  ResponderFacade::send('task', $task);
    }

    public function store(TaskStoreRequest $request)
    {
        $created_task = TaskRepository::store($request->only(['title', 'description', 'labels', 'user_id']));

        $created_task->getOrSend(
            [ResponderFacade::class, 'modelDidntCreate']
        );

        return ResponderFacade::success();
    }

    public function update(TaskUpdateRequest $request)
    {
        $task = TaskRepository::findOne($request->id)->getOrSend(
            [ResponderFacade::class, 'notFound']
        );

        TaskRepository::update($task, [
            'title' => $request->title,
            'description' => $request->description
        ]);

        return ResponderFacade::send('updated_task', $task);
    }

    public function changeStatus(TaskChangeStatusRequest $request)
    {
        $task = TaskRepository::findOne($request->id)->getOrSend(
            [ResponderFacade::class, 'notFound']
        );

        TaskRepository::update($task, [
            'status' => $request->status
        ]);


        SendTaskNotifJob::dispatch(
            NotificationFacade::send(Auth::user(), $task)
        )
            ->onQueue('high');

        return ResponderFacade::send('updated_task', $task);
    }

    public function labelsIndex()
    {
        $labels = TaskRepository::labelsIndex();

        return  ResponderFacade::send('tasks', $labels);
    }

    public function addLabels(AddLabelRequest $request)
    {
        $task = TaskRepository::findOne($request->id)->getOrSend(
            [ResponderFacade::class, 'notFound']
        );

        $task = TaskRepository::addLabels($task, $request->labels);

        $task->getOrSend(
            [ResponderFacade::class, 'modelDidntCreate']
        );

        return ResponderFacade::success();
    }

    public function assignLabels(AssignLabelRequest $request)
    {
        $task = TaskRepository::findOne($request->id)->getOrSend(
            [ResponderFacade::class, 'notFound']
        );

        $task = TaskRepository::assignLabelsWithId($task, $request->labels);

        $task->getOrSend(
            [ResponderFacade::class, 'modelDidntCreate']
        );

        return ResponderFacade::success();
    }
}
