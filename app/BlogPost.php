<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class BlogPost extends Model
{

    use SoftDeletes;

    // protected $table = 'blogpost';
    protected $fillable = ['title', 'content'];

        // this method name should be related to the related table with id
    // laravel will convert it to comments_id while searching for a foreign key
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public static function boot()
    {
        parent::boot();

        // Way1 - this deletes a BlogPost and related comments

        static::deleting(function(BlogPost $blogPost) {
            $blogPost->comments()->delete();
        });


    }
}
