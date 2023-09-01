<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use App\Services\PostService;
use App\Services\CategoryService;
use App\Http\Requests\PostRequest;


class PostApiController extends Controller
{
    protected $postService;
    protected $categoryService;
    protected $apiData;

    public function __construct(PostService $postService, CategoryService $categoryService)
    {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
        $this->apiData = [
                    "status"    => "error",
                    "message"   => "",
                    "data"      => [] 
                ];
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
        
        return response()->json($posts);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //$this->authorize('create', Post::class);

        $postData = $request->only(['title', 'description']);
        $user = auth()->user(); //auth user
        $user = User::find(5);
        $post = $this->postService->createWithAuthor($user, $postData);

        if($post) {

            $inputCategory = $request->input('category');
            if($inputCategory) {
                $categories = $this->categoryService->whereInField('id', $inputCategory);
                $post->categories()->sync($categories);        
            }       
        
            $this->apiData["status"] = "success"; 
            $this->apiData["message"] = 'Post updated successfully'; 
            $this->apiData["data"] = $post; 
        
        } else {
            $this->apiData["message"] = 'Error in updating record.'; 
        }

        return response()->json($this->apiData); 
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {   
        if($post) {
            $this->apiData["status"] = "success"; 
            $this->apiData["data"] = $post; 
        }

        return response()->json($this->apiData);                   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, $post)
    {
        
        /* $this->authorize('update', $post);

        $request->validate([
            'title' => 'required',
            'description' => 'required',
        ]); */
        return response()->json($this->apiData);
        $postData = $request->only(['title', 'description']);
        $post = $this->postService->update($post, $postData);

        if($post) {

            $inputCategory = $request->input('category');
            if($inputCategory) {
                $categories = $this->categoryService->whereInField('id', $inputCategory);
                $post->categories()->sync($categories);        
            }        
        
            $this->apiData["status"] = "success"; 
            $this->apiData["message"] = 'Post updated successfully'; 
            $this->apiData["data"] = $post; 
        
        } else {
            $this->apiData["message"] = 'Error in deleting record.'; 
        }

        return response()->json($this->apiData);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {

        if($this->postService->delete($post)) {
            $this->apiData["status"] = "success"; 
            $this->apiData["message"] = 'Post deleted successfully'; 
        } else {
            $this->apiData["message"] = 'Error in deleting record.'; 
        }

        return response()->json($this->apiData);
    }
}