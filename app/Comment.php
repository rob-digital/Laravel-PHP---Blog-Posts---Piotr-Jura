<?php

namespace App;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;

    // blog_post_id
    public function blogPost()
    {
        // return $this->belongsTo('App\BlogPost', 'post_id', 'blog_post_id');
        return $this->belongsTo('App\BlogPost');

    }
    public function scopeLocalQueryScopeLatestOnTop($query)  // local query scope to sort from decs
    {                                                        // it must start with 'scope'
        return $query->orderBy(static::CREATED_AT, 'desc');   // use it in PostController where you fetch comments
    }
    public static function boot()
    {
        parent::boot();

        // static::addGlobalScope(new LatestScope);
    }
}
