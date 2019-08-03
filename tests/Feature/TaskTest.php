<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Carbon\Carbon;

class TaskTest extends TestCase
{
    const CREATE_TASK = 'create tasks';
    const UPDATE_TASK = 'update tasks';

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testTaskIndex()
    {
        $this->loginAsUser();

        $this->call('get', route('tasks.index'))
             ->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test create task.
     *
     * @return void
     */
    public function testCreateTask()
    {
        $user = $this->loginAsUser();

        $this->call('POST', route('tasks.store'), [
            'name' => self::CREATE_TASK,
            'user_id' => $user->id
        ])->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('tasks', [
            'user_id'  => $user->id,
            'name' => self::CREATE_TASK
        ]);
    }

    /**
     * It is used to test when create a task, the name is empty.
     *
     * @return void
     */
    public function testCreateTaskFail()
    {
        $user = $this->loginAsUser();

        $this->postJson(route('tasks.store'), [
            'user_id' => $user->id,
            'name' => ''
        ])  ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors('name');
    }

    public function testUpdateTask()
    {
        $user = $this->loginAsUser();

        $task = $user->tasks()->create([
            'name' => self::CREATE_TASK,
            'user_id' => $user->id
        ]);

        $this->call('PUT', '/tasks/update/' . $task->id , [
            'name' => self::UPDATE_TASK
        ])  ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('tasks', [
            'user_id'  => $user->id,
            'id' => $task->id,
            'name' => self::UPDATE_TASK
        ]);

        $this->assertDatabaseHas('logs', [
            'user_id'  => $user->id,
            'desc' => 'Task ' . $task->id . ' is updated by user ' . $user->id,
        ]);
    }

    /**
     * It is used to test when update a task, the name is empty.
     *
     * @return void
     */
    public function testUpdateTaskFail()
    {
        $user = $this->loginAsUser();

        $task = $user->tasks()->create([
            'name' => self::CREATE_TASK,
            'user_id' => $user->id
        ]);

        $this->putJson('/tasks/update/' . $task->id, [
            'user_id' => $user->id,
            'name' => ''
        ])  ->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY)
            ->assertJsonValidationErrors('name');

        $this->assertDatabaseHas('tasks', [
            'user_id'  => $user->id,
            'id' => $task->id,
            'name' => self::CREATE_TASK
        ]);
    }

    public function testDeleteTask()
    {
        $user = $this->loginAsUser();
        $task = $user->tasks()->create([
            'name' => self::CREATE_TASK,
            'user_id' => $user->id
        ]);

        $this->delete('/tasks/delete/' . $task->id)
             ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseMissing('tasks', [
            'id'  => $task->id,
            'name'     => self::CREATE_TASK
        ]);

        $this->assertDatabaseHas('logs', [
            'user_id'  => $user->id,
            'desc' => 'Task ' . $task->id . ' is deleted by user ' . $user->id,
        ]);
    }

    public function testMarkDone()
    {
        $user = $this->loginAsUser();
        $task = $user->tasks()->create([
            'name' => self::CREATE_TASK
        ]);

        $this->put('/tasks/mark/' . $task->id . '/done/')
             ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('tasks', [
                'user_id'  => $user->id,
                'id' => $task->id,
                'finished_at' => Carbon::now()
            ]);

        $this->assertDatabaseHas('logs', [
                'user_id'  => $user->id,
                'desc' => 'Task ' . $task->id . ' is done by user ' . $user->id,
            ]);
    }

    public function testMarkUndone()
    {
        $user = $this->loginAsUser();
        $task = $user->tasks()->create([
            'name' => self::CREATE_TASK
        ]);

        $this->put('/tasks/mark/' . $task->id . '/done/');
        $this->put('/tasks/mark/' . $task->id . '/undone/')
             ->assertStatus(Response::HTTP_OK);

        $this->assertDatabaseHas('tasks', [
                'user_id'  => $user->id,
                'id' => $task->id,
                'finished_at' => NULL
            ]);

        $this->assertDatabaseHas('logs', [
                'user_id'  => $user->id,
                'desc' => 'Task ' . $task->id . ' is undone by user ' . $user->id,
            ]);
    }
}