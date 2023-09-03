<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Role;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use App\Services\PostService;
use App\Services\CategoryService;

class PostController extends Controller
{
    protected $postService;
    protected $categoryService;

    public function __construct(PostService $postService, CategoryService $categoryService)
    {
        $this->postService = $postService;
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
        $posts = $this->postService->latest($paginate);
    
        return view('posts.index',compact('posts'))
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

        $categories = $this->categoryService->all();

        return view('posts.create', compact('categories'));
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
            'title' => 'required',
            'description' => 'required',
        ]);


        $postData = $request->only(['title', 'description']);
        $user = auth()->user();
        $post = $this->postService->createWithAuthor($user, $postData);

        $inputCategory = $request->input('category');
        if($inputCategory) {
            $categories = $this->categoryService->whereInField('id', $inputCategory);
            $post->categories()->sync($categories);        
        }

        return redirect()->route('posts.index')
                        ->with('success','Post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {    
        /* authorize using policy 
        $this->authorize('view', $post);
        $response = Gate::inspect('view', $post);
        if (!$response->allowed()) {
            abort(403, $response->message());
        }
        */

        /* authorize using gate
        if (Gate::denies('view-post', $post)) {
            abort(403, "You don't have permission to access.");
        }   
        */
        //$post = $this->postService->find($id);
        return view('posts.show',compact('post'));                    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $this->authorize('update', $post);
        $categories = $this->categoryService->all();

        return view('posts.edit',compact('post', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        
        $this->authorize('update', $post);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
        
        $postData = $request->only(['title', 'description']);
        $post = $this->postService->update($post, $postData);

        $inputCategory = $request->input('category');
        if($inputCategory) {
            $categories = $this->categoryService->whereInField('id', $inputCategory);
            $post->categories()->sync($categories);        
        }        
    
        return redirect()->route('posts.index')
                        ->with('success','Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $this->authorize('delete', $post);
        
        $this->postService->delete($post);
    
        return redirect()->route('posts.index')
                        ->with('success','Post deleted successfully');
    }
}