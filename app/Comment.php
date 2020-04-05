<?php

namespace App;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class Comment extends Model
{
    use SoftDeletes;

    protected $fillable = ['user_id', 'content'];


    // blog_post_id
    // public function blogPost()
    // {
    //     // return $this->belongsTo('App\BlogPost', 'post_id', 'blog_post_id');
    //     return $this->belongsTo('App\BlogPost');
    // }

    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }


    public function scopeLocalQueryScopeLatestOnTop($query)  // local query scope to sort from decs
    {                                                        // it must start with 'scope'
        return $query->orderBy(static::CREATED_AT, 'desc');   // use it in PostController where you fetch comments
    }
    public static function boot()
    {
        parent::boot();

        parent::boot();

        static::creating(function (Comment $comment) {
            // dump($comment);
            // dd(BlogPost::class);
            if ($comment->commentable_type === BlogPost::class) {
                Cache::forget("blog-post-{$comment->commentable_id}");
                Cache::forget('mostCommented');
            }
        });
        // static::addGlobalScope(new LatestScope);
    }
}
