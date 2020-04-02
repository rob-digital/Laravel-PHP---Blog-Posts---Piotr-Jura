<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

    //    $doe = factory(App\User::class)->states('john-doe')->create();
    //    $others = factory(App\User::class, 20)->create();  // returns a collection

    //     $allUsers = $others->concat([$doe]);

    //     // ->make() --- creates instances of a BlogPost Models and don't save them
    //     // ->each() --- allows to iterate over the collection, to do something with each element
    //     $posts = factory(App\BlogPost::class, 50)->make()->each(function($post) use ($allUsers) {
    //         $post->user_id = $allUsers->random()->id;
    //         $post->save();
    //     });

    //     $comments = factory(App\Comment::class, 150)->make()->each(function($comment) use ($posts) {
    //         $comment->blog_post_id = $posts->random()->id;
    //         $comment->save();
    //     });


        if ($this->command->confirm('Do you want to refresh the database?')) {
            $this->command->call('migrate:refresh');
            $this->command->info('Database was refreshed');
        }

        Cache::tags(['blog-post'])->flush();

        $this->call([
            UsersTableSeeder::class,
            BlogPostsTableSeeder::class,
            CommentsTableSeeder::class,
            TagsTableSeeder::class
    ]);
}

    }

