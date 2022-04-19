<?php

namespace MatinEbrahimii\ToDo;

use Illuminate\Support\Collection;
use MatinEbrahimii\ToDo\Models\Task;
use MatinEbrahimii\ToDo\Models\Label;
use MatinEbrahimii\ToDo\Facades\ResponderFacade;
use MatinEbrahimii\ToDo\Facades\NotificationFacade;
use MatinEbrahimii\ToDo\Facades\Repositories\TaskRepository;

class TaskControllerTest extends BaseTest
{
    private $base_url = 'api/todo/tasks';

    public function test_task_index_method()
    {
        $this->withoutExceptionHandling();

        $collection = new Collection();

        TaskRepository::shouldReceive('all')->once()->andReturn($collection);
        ResponderFacade::shouldReceive('send')->once()->andReturn(json_encode(['tasks' => $collection]));

        $response = $this->user()->get($this->base_url);
        $response->assertStatus(200);
    }

    public function test_add_task()
    {
        $this->withoutExceptionHandling();

        $data = [
            'title' => 'title_test',
            'description' => 'description_test',
        ];

        $user = $this->makeUser();

        ResponderFacade::shouldReceive('success')->once();
        ResponderFacade::shouldReceive('modelDidntCreate')->never();

        $this->user($user)->post($this->base_url, $data);

        $this->assertDatabaseCount('tasks', 1);
        $task = Task::first();
        $this->assertDatabaseHas(
            'tasks',
            [
                'id' => $task->id,
                'title' => 'title_test',
                'description' => 'description_test',
                'status' => 'pending',
                'user_id' => $user->id,
            ]
        );
    }

    public function test_show_detail_of_a_task()
    {
        $user = $this->makeUser();
        $task = $this->makeTask($user);
        $label = $this->makeLabel();
        $task->labels()->attach($label->id);

        $response = $this->user($user)->get($this->base_url . '/' . "{$task->id}");

        $response->assertExactJson([
            'task' => [
                'id' => $task->id,
                'title' => $task->title,
                'description' => $task->description,
                'status' => $task->status,
                'labels' => [
                    [
                        'id' => $label->id,
                        'title' => $label->title,
                        'description' => $label->description,
                    ]
                ]
            ]
        ]);
    }

    public function test_edit_description_and_title_of_a_task()
    {
        $this->withoutExceptionHandling();

        ResponderFacade::shouldReceive('send')->once();
        ResponderFacade::shouldReceive('notFound')->never();

        $user = $this->makeUser();
        $task = $this->makeTask($user);


        $data = [
            'title' => 'updated_title',
            'description' => 'updated_description'
        ];

        $response = $this->user($user)->put($this->base_url . '/' . "{$task->id}", $data);
        $response->assertStatus(200);


        $this->assertDatabaseCount('tasks', 1);
        $this->assertDatabaseHas(
            'tasks',
            [
                'id' => $task->id,
                'title' => 'updated_title',
                'description' => 'updated_description'
            ]
        );
    }

    public function test_change_task_status()
    {
        $user = $this->makeUser();

        $task = $this->makeTask($user);

        NotificationFacade::shouldReceive('send')
            ->once()
            ->withArgs(fn ($user, $task) => true)
            ->andReturn();

        $response = $this->user($user)->post($this->base_url . "/{$task->id}/changeStatus", ['status' => 'done']);
        $response->assertStatus(200);

        $this->assertDatabaseCount('tasks', 1);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'done']);
    }

    public function test_add_a_label_or_labels_to_task()
    {
        $this->withoutExceptionHandling();


        $user = $this->MakeUser();
        $task = $this->makeTask($user);

        $data = [
            'labels' => [
                [
                    'title' => 'title1',
                    'description' => 'desc1'
                ],
                [
                    'title' => 'title2',
                    'description' => 'desc2'
                ]
            ]
        ];

        // TaskRepository::shouldReceive('addLabels')
        //     ->once()
        //     ->with($task->id, $data['labels'])
        //     ->andReturn(
        //         nullable(new Task($data))
        //     );

        // TaskRepository::shouldReceive('findOne')
        //     ->once()
        //     ->with($task->id)
        //     ->andReturn(nullable(new Task($data)));

        ResponderFacade::shouldReceive('success')->once();
        ResponderFacade::shouldReceive('modelDidntCreate')->never();
        ResponderFacade::shouldReceive('notFound')->never();

        $response = $this->user($user)->post($this->base_url . '/' . $task->id . '/labels', $data);

        $this->assertDatabaseCount('tasks', 1);
        $this->assertDatabaseHas('tasks', ['id' => $task->id, 'status' => 'pending']);

        $labels_ids = Label::get('id')->pluck('id')->toArray();
        $this->assertDatabaseCount('labels', 2);
        $this->assertDatabaseHas('labels', ['id' => $labels_ids['0'], 'title' => 'title1', 'description' => 'desc1']);
        $this->assertDatabaseHas('labels', ['id' => $labels_ids['1'], 'title' => 'title2', 'description' => 'desc2']);

        $this->assertDatabaseCount('label_task', 2);
        $this->assertDatabaseHas('label_task', ['task_id' => $task->id, 'label_id' => $labels_ids['0']]);
        $this->assertDatabaseHas('label_task', ['task_id' => $task->id, 'label_id' => $labels_ids['1']]);
    }

    public function test_assign_a_label_or_labels_to_task()
    {
        $this->withoutExceptionHandling();

        $user = $this->MakeUser();
        $task = $this->makeTask($user);
        $label = $this->makeLabel();

        ResponderFacade::shouldReceive('success')->once();
        ResponderFacade::shouldReceive('modelDidntCreate')->never();
        ResponderFacade::shouldReceive('notFound')->never();

        $this->user($user)->post($this->base_url . '/' . $task->id . '/labels/assign', ['labels' => [$label->id]]);

        $this->assertDatabaseCount('labels', 1);
        $this->assertDatabaseHas('labels', ['id' => $label->id, 'title' => 'title_test', 'description' => 'description_test']);

        $this->assertDatabaseCount('label_task', 1);
        $this->assertDatabaseHas('label_task', ['task_id' => $task->id, 'label_id' => $label->id,]);
    }
}
