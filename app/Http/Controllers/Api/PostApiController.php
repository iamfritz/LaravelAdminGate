<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\Role;
use App\Models\Category;
use Illuminate\Support\Facades\Gate;
use App\Services\PostService;

class PostApiController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->postService = $postService;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        #$posts = Post::latest()->paginate(5);
        $posts = $this->postService->all();
    
        return response()->json($posts);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authorize('create', Post::class);

        $categories = Category::get();

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

        #$postData = $request->only(['title', 'description']);
        #$post     = Post::create($postData);
        
        $post = new Post();
        $post->title = $request->input('title');
        $post->description = $request->input('description');

        // Get the authenticated user and associate the post with the user
        $user = auth()->user();
        $post->user()->associate($user);
        $post->save();

        $inputCategory = $request->input('category');
        if($inputCategory) {
            $categories = Category::whereIn('id', $inputCategory)->get();
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
        $categories = Category::get();

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
        $post->update($postData);

        $inputCategory = $request->input('category');
        if($inputCategory) {
            $categories = Category::whereIn('id', $inputCategory)->get();
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

        $post->delete();
    
        return redirect()->route('posts.index')
                        ->with('success','Post deleted successfully');
    }
}
