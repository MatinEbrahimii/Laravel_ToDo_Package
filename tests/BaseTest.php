<?php

namespace MatinEbrahimii\ToDo;

use MatinEbrahimii\ToDo\TestCase;
use MatinEbrahimii\ToDo\Models\Task;
use MatinEbrahimii\ToDo\Models\User;
use MatinEbrahimii\ToDo\Models\Label;
use Illuminate\Foundation\Testing\RefreshDatabase;

class BaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_example()
    {
        $this->assertTrue(true);
    }

    public function user($user = null)
    {
        if ($user == null) {
            $user = User::create(
                [
                    'name' => 'test',
                    'email' => 'test@example.com',
                    'password' => 'er2@hgH',
                    'token' => 'token'
                ]
            );
        }

        return $this->actingAs($user)
            ->withHeaders([
                'Authorization' => 'Bearer token',
            ]);
    }

    protected function makeTask($user = null)
    {
        // $task = factory(Task::class)->create();

        return Task::create([
            'title' => 'title_test',
            'description' => 'description_test',
            'status' => 'pending',
            'user_id' => $user ? $user->id : 1,
        ]);
    }

    protected function makeUser()
    {
        return User::create(
            [
                'name' => 'test',
                'email' => 'test@example.com',
                'password' => 'er2@hgH',
                'token' => 'token'
            ]
        );
    }

    protected function makeLabel()
    {
        return Label::create([
            'title' => 'title_test',
            'description' => 'description_test',
        ]);
    }
}
