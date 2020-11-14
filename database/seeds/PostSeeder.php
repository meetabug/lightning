<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\User;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class, 12)->make()->each(function (Post $post) {
            User::inRandomOrder()->first()->posts()->save($post);
        });
    }
}
