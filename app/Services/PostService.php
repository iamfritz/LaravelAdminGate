<?php
// app/Services/PostService.php

namespace App\Services;

use App\Models\Post;

class PostService extends BaseService
{
    public function __construct(Post $model)
    {
        parent::__construct($model);
    }

    // Additional methods specific to the Category model, if needed
    public function createWithAuthor($user, array $postData)
    {
        $post = new Post($postData);
        //$author->posts()->save($post);
        $post->user()->associate($user);
        $post->save();        

        return $post;
    }
    public function findwithPostCount($id)
    {
        return $this->model->withCount('posts')->find($id);
    }

    public function latest($paginate)
    {
        return $this->model->latest()->paginate($paginate);
    }
}
