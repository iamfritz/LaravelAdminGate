<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $data = Post::latest()->paginate(5);
    
        return view('posts.index',compact('data'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
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
        $response = Gate::inspect('view', $post); // connected to Post Policy
        if ($response->allowed()) {
            #echo 'The action is authorized...';
            return view('posts.show',compact('post'));
        } else {
            //echo $response->message();
            //abort(403, 'Unauthorized action.');
            abort(403, $response->message());
        }                
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        if (! Gate::allows('update-post', $post)) {
            abort(403);
        }        
        return view('posts.edit',compact('post'));
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
        
        if (! Gate::allows('update-post', $post)) {
            abort(403);
        }

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]);
    
        $post->update($request->all());
    
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
        if (Gate::allows('admin')) {

            $post->delete();
        
            return redirect()->route('posts.index')
                            ->with('success','Post deleted successfully');
        } else {
            abort(403, $response->message());            
        }        
    }
}