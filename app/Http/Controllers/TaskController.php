<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Models\Task;
use App\Services\TaskService;
use App\Services\UserService;

class TaskController extends Controller
{
    protected $taskService;
    protected $level;
    protected $status;

    public function __construct(TaskService $taskService, UserService $userService)
    {
        $this->taskService = $taskService;
        $this->userService = $userService;
        $this->level = ['low', 'medium', 'high'];
        $this->status = ['todo', 'in-progress', 'done', 'failed', 'completed'];
    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = 5;
        $data = $this->taskService->latestWithUsers($paginate);
        
        return view('tasks.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * $paginate);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Post::class);
        
        $users = $this->userService->getUserRole();
        $level = $this->level;
        return view('tasks.create', compact('users', 'level'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authorize('create', Post::class);

        $request->validate([
            'title'         => 'required|unique:posts,title',
            'description'   => 'required',
            'level'         => 'required',
            'assigned_to'   => 'required'
        ]);
        
        $taskData = $request->only(['title', 'description', 'level', 'assigned_to']);
        $user = auth()->user();
        $taskData['author_id'] = $user->id;
        $this->taskService->create($taskData);

        return redirect()->route('tasks.index')
                        ->with('success','Task created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {    
        $task = $this->taskService->find($id);

        return view('tasks.show',compact('task'));                    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        $this->authorize('create', Post::class);

        $users = $this->userService->all()->sortBy("name");
        $users = $this->userService->byRole('user');
        $level = $this->level;
        $status = $this->status;

        return view('tasks.edit', compact('task', 'users', 'level', 'status'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        
        //$this->authorize('create', Task::class);

        $request->validate([
            'title'         => 'required|unique:posts,title,' . $task->id,
            'description'   => 'required',
            'level'         => 'required',
            'assigned_to'   => 'required'
        ]);
        
        $taskData = $request->only(['title', 'description', 'level', 'assigned_to', 'status']);

        $this->taskService->update($task, $taskData);
    
        return redirect()->route('tasks.index')
                        ->with('success','Task updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //$this->authorize('create', Post::class);

        $this->taskService->delete($task);
    
        return redirect()->route('tasks.index')
                        ->with('success','Task deleted successfully');
    }
}