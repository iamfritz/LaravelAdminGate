<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Services\TaskService;

class TaskController extends Controller
{
    protected $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = 5;
        $data = $this->taskService->latestwithPostCount($paginate);

        return view('task.index',compact('data'))
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

        return view('task.create');
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
            'title' => ['required', 'string', 'max:255', 'unique:categories'],
        ]);
        
        $catData = $request->only(['title']);
        $this->taskService->create($catData);

        return redirect()->route('task.index')
                        ->with('success','Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {    
        $task = $this->taskService->findwithPostCount($id);
        return view('task.show',compact('task'));                    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $task)
    {
        $this->authorize('create', Post::class);

        return view('task.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $task)
    {
        
        //$this->authorize('update', $task);
        $this->authorize('create', Post::class);

        $request->validate([
            'title' => 'required|max:255|unique:categories,title,' . $task->id
        ]);
        $catData = $request->only(['title']);

        $this->taskService->update($task, $catData);
    
        return redirect()->route('task.index')
                        ->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $task)
    {
        $this->authorize('create', Post::class);

        $this->taskService->delete($task);
    
        return redirect()->route('task.index')
                        ->with('success','Category deleted successfully');
    }
}