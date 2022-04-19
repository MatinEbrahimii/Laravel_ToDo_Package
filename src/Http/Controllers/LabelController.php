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
}
