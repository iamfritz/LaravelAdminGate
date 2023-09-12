<?php
// app/Services/PostService.php

namespace App\Services;
use App\Services\CategoryService;

use App\Models\Post;

class PostService extends BaseService
{
    protected $categoryService;
    public function __construct(Post $model, CategoryService $categoryService)
    {
        parent::__construct($model);
        $this->categoryService = $categoryService;
    }
    public function latestWithCategory($paginate)
    {
        return $this->model->with('categories:title')->latest()->paginate($paginate);
    }
    public function findWithCategory($id)
    {
        return $this->model->with('categories:title')->find($id);
    }    
    /**
     * create post with user
     * $user
     * $postData
     * $field = id or tile category table
     */    
    public function createWithAuthor($user, array $postData, $field="id")
    {
        $post = new Post($postData);        
        $post->user()->associate($user);
        $post->save();

        if (isset($postData['category'])) {            
            $post = $this->syncCategory($post, $postData['category'], $field);
        }

        return $post;
    }
    /**
     * update post with Category
     * $post
     * $postData
     * $field = id or tile category table
     */    
    public function updateWithCategory($post, array $postData, $field="id")
    {
        $this->update($post, $postData);

        if (isset($postData['category'])) {            
            $post = $this->syncCategory($post, $postData['category'], $field);
        }

        return $post;
    }
    /**
     * sync post category
     * $post
     * $category array
     * $field = id or tile category table
     */ 
    public function syncCategory($post, $inputCategory, $field)
    {   
        if($post && $inputCategory) {
            /* upInsert */
            if($field == 'title') {
                $inputCategory = $this->categoryService->findInsert($inputCategory);
            } 

            $categories = $this->categoryService->whereInField('id', $inputCategory);
            if($categories) 
                $post->categories()->sync($categories);
        }

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
