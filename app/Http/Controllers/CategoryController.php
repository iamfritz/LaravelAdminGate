<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Services\CategoryService;

class CategoryController extends Controller
{
    protected $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $paginate = 5;
        $data = $this->categoryService->latestwithPostCount($paginate);

        return view('category.index',compact('data'))
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

        return view('category.create');
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
        $this->categoryService->create($catData);        

        return redirect()->route('category.index')
                        ->with('success','Category created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {    
        $category = $this->categoryService->findwithPostCount($id);
        return view('category.show',compact('category'));                    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //$this->authorize('update', $category);

        return view('category.edit',compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        
        //$this->authorize('update', $category);

        $request->validate([
            'title' => 'required|max:255|unique:categories,title,' . $category->id
        ]);
        $catData = $request->only(['title']);

        $this->categoryService($catData);
    
        return redirect()->route('category.index')
                        ->with('success','Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        //$this->authorize('delete', $category);

        $this->categoryService->delete($category);
    
        return redirect()->route('category.index')
                        ->with('success','Category deleted successfully');
    }
}