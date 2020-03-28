<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    // protected $table = 'blogpost';
    protected $fillable = ['title', 'content'];

        // this method name should be related to the related table with id
    // laravel will convert it to comments_id while searching for a foreign key
    public function comments()
    {
        return $this->hasMany('App\Comment');
    }
}
