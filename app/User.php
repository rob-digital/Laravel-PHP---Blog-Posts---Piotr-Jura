<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function blogPosts()
    {
        return $this->hasMany(BlogPost::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function commentsOn()
    {
        return $this->morphMany('App\Comment', 'commentable')->localQueryScopeLatestOnTop();
    }

    public function image()
    {
        return $this->morphOne(Image::class, 'imageable');
    }

    public function scopeWithMostBlogPosts($query)
    {
        //laravel will return a new filed 'blog_posts_count' it  will be added to select statement
        return $query->withCount('blogPosts')->orderBy('blog_posts_count', 'desc');

    }

    public function scopeWithMostBlogPostsLastMonth($query)
    {
        return $query->withCount(['blogPosts' => function($query) {
            $query->whereBetween(static::CREATED_AT, [now()->subMonth(1), now()]);
        }])
        ->has('blogPosts', '>=', 2)
        ->orderBy('blog_posts_count', 'desc');
    }
}
