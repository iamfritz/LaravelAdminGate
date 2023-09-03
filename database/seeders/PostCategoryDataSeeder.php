<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Category;

class PostCategoryDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 categories
        $categories = Category::factory(10)->create();
        
        // Create 20 posts and attach 2 random categories to each post
        Post::factory(10)->create()->each(function ($post) use ($categories) {
            $post->categories()->sync(
                $categories->random(2)->pluck('id')
            );
        });
    }
}
