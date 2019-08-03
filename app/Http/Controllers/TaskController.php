<?php

namespace Fitest\Http\Controllers;

use Illuminate\Http\Request;
use Fitest\Services\TaskService;
use Fitest\Http\Requests\TaskRequest;
use Auth;

class TaskController extends Controller
{
    /**
     * @var TaskService
     */
    protected $taskService;

    public function __construct(TaskService $taskService) 
    {
        $this->middleware(['auth'])->except('show', 'create', 'edit');  //Or ->only('store', 'update', 'destory');
        $this->taskService = $taskService;
        $this->user = Auth::user();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return response()->json(Auth::user()->tasks);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(TaskRequest $request)
    {
        $request->validated();
        $user = Auth::user();
        $this->taskService->createTask($request->all(), $user);
        
        return response()->json($user->tasks);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(TaskRequest $request, int $taskId)
    {
        $request->validated();
        $task = $this->user->tasks()->find($taskId);

        $this->authorize('match', $task);   // check if the authenticated user can match the task. The second param must be an object.
        $this->taskService->updateTask($request->all(), $task);

        return response()->json($this->user->tasks()->find($taskId));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $taskId
     * @return \Illuminate\Http\Response
     */
    public function destory(int $taskId)
    {
        $user = Auth::user();
        $task = $user->tasks()->find($taskId);

        $this->authorize('match', $task);  // check if the authenticated user can match the task. The second param must be an object.
        $task->delete();

        return response()->json($user->tasks);
    }

    public function markTaskDone(int $taskId)
    {
        $user = Auth::user();
        $task = $user->tasks()->find($taskId);
        $this->taskService->markTaskDone($task);

        return response()->json($user->tasks);
    }

    public function markTaskUndone(int $taskId)
    {
        $user = Auth::user();
        $task = $user->tasks()->find($taskId);
        $this->taskService->markTaskUndone($task);

        return response()->json($user->tasks);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
}
