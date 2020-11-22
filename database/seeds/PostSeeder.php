<?php

use Illuminate\Database\Seeder;
use App\Post;
use App\User;
use App\Comment;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Post::class, 60)->make()->each(function (Post $post) {
            User::inRandomOrder()->first()->posts()->save($post);

            factory(Comment::class, random_int(0, 3))->make()
                ->each(function (Comment $comment) use ($post) {
                    $comment->commenter()->associate(User::inRandomOrder()->first());
                    $comment->post()->associate($post);
                    $comment->save();
                });
        });
    }
}
