<?php

namespace MatinEbrahimii\ToDo\Http\Controllers;

use MatinEbrahimii\ToDo\Facades\ResponderFacade;
use Illuminate\Routing\Controller;
use MatinEbrahimii\ToDo\Http\Requests\Label\LabelStoreRequest;
use MatinEbrahimii\ToDo\Facades\Repositories\LabelRepository;

class LabelController extends Controller
{
    public function index()
    {
        $labels = LabelRepository::all();

        return  ResponderFacade::send('labels', $labels);
    }

    public function show($id)
    {
        $label = LabelRepository::findOne($id);

        $label = $label->getOrSend(
            [ResponderFacade::class, 'notFound']
        );

        return  ResponderFacade::send('label', $label);
    }

    public function store(LabelStoreRequest $request)
    {
        $created_label = LabelRepository::store($request->only(['title', 'description']));

        $created_label->getOrSend(
            [ResponderFacade::class, 'modelDidntCreate']
        );

        return ResponderFacade::success();
    }

    // public function update(LabelUpdateRequest $request)
    // {
    //     $label = LabelRepository::findOne($request->id)->getOrSend(
    //         [ResponderFacade::class, 'modelNotFound']
    //     );

    //     LabelRepository::update($label, [
    //         'title' => $request->title,
    //         'description' => $request->description
    //     ]);

    //     return ResponderFacade::send('updated_task', $label);
    // }

    // public function changeStatus(TaskChangeStatusRequest $request)
    // {
    //     $label = LabelRepository::findOne($request->id)->getOrSend(
    //         [ResponderFacade::class, 'modelNotFound']
    //     );

    //     LabelRepository::update($label, [
    //         'status' => $request->status
    //     ]);

    //     return ResponderFacade::send('updated_task', $label);
    // }
}
