<?php

namespace MatinEbrahimii\ToDo;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use MatinEbrahimii\ToDo\Models\Task;
use MatinEbrahimii\ToDo\Models\User;
use MatinEbrahimii\ToDo\Models\Label;
use MatinEbrahimii\ToDo\Facades\ResponderFacade;
use MatinEbrahimii\ToDo\Facades\Repositories\LabelRepository;

class LabelControllerTest extends BaseTest
{
    private $base_url = 'api/todo/labels';

    public function test_label_index_method()
    {
        $this->withExceptionHandling();

        $collection = new Collection();

        LabelRepository::shouldReceive('all')->once()->andReturn($collection);
        ResponderFacade::shouldReceive('send')->once()->andReturn(json_encode(['Labels' => $collection]));

        $response = $this->user()->get($this->base_url);
        $response->assertStatus(200);
    }

    public function test_add_label()
    {
        $data = [
            'title' => 'title_test',
            'description,' => 'description_test',
            'status' => 'pending'
        ];

        LabelRepository::shouldReceive('store')->once()->andReturn(nullable(new Label($data)));
        ResponderFacade::shouldReceive('success')->once();
        ResponderFacade::shouldReceive('modelDidntCreate')->never();

        $response = $this->user()->post($this->base_url, $data);
        $response->assertStatus(200);
    }

    public function test_show_detail_of_a_lebel()
    {
        $user = $this->makeUser();
        $task = $this->makeTask($user);
        $label = $this->makeLabel();
        $task->labels()->attach($label->id);

        $response = $this->user($user)->get($this->base_url . '/' . "{$label->id}");
        $response->assertExactJson([
            'label' => [
                'id' => $label->id,
                'title' => $label->title,
                'description' => $label->description,
                "tasks" => [
                    [
                        "id" => $task->id,
                        "title" => "title_test",
                        "description" => "description_test"
                    ]
                ]
            ]
        ]);
    }
}
