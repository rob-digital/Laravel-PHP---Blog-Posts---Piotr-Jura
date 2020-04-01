<?php

namespace App;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class BlogPost extends Model
{

    use SoftDeletes;

    // protected $table = 'blogpost';
    protected $fillable = ['title', 'content', 'user_id'];

        // this method name should be related to the related table with id
    // laravel will convert it to comments_id while searching for a foreign key
    public function comments()
    {
        return $this->hasMany('App\Comment')->localQueryScopeLatestOnTop();
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function scopeLocalQueryScopeLatestOnTop($query)  // local query scope to sort from decs
    {                                                        // it must start with 'scope'
        return $query->orderBy(static::CREATED_AT, 'desc');   // use it in PostController where you fetch posts
    }

    public function scopeMostCommented(Builder $query)
    {
        //  this will produce field 'comments count'
        return $query->withCount('comments')->orderBy('comments_count', 'desc');
    }





    public static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new LatestScope);

        // Way1 - this deletes a BlogPost and related comments
        static::deleting(function(BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });
        static::restoring(function (BlogPost $blogPost) {
            $blogPost->comments()->restore();
        });
    }
}
