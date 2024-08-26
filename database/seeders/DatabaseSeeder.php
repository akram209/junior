<?php

namespace Database\Seeders;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(10)->create()->each(function ($user) {
            // For each user, create 5 posts
            Post::factory(5)->create([
                'user_id' => $user->id,
                'title' => 'Lorem ipsum dolor sit amet',
                'content' => 'Lorem ipsum dolor sit amet',

            ])->each(function ($post) use ($user) {
                // For each post, create 3 comments
                Comment::factory(3)->create([
                    'post_id' => $post->id,
                    'user_id' => $user->id,
                    'content' => 'Lorem ipsum dolor sit amet', // Assign the comment to the post's author or random user
                ]);
            });
        });
    }
}
