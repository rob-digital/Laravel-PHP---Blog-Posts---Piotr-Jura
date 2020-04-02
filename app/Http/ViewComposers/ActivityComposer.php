<?php

namespace App\Http\ViewComposers;

use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use App\BlogPost;
use App\User;


class ActivityComposer
{
    public function compose(View $view)
    {
        $mostCommented = Cache::remember('mostCommentedPosts_uniqueVariable', 60, function() {
            return BlogPost::mostCommented()->take(5)->get();
        });

        $mostActive = Cache::remember('mostActiveUsers_uniqueVariable', 60, function() {
            return User::withMostBlogPosts()->take(5)->get();
        });

        $mostActiveLastMonth = Cache::remember('mostActiveUsersLastMonth_uniqueVariable', 60, function() {
            return User::withMostBlogPostsLastMonth()->take(5)->get();
        });

        $view->with('variable_most_commented', $mostCommented);
        $view->with('variable_most_active_users', $mostActive);
        $view->with('variable_most_active_last_month', $mostActiveLastMonth);

    }
}
