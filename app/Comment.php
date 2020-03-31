<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comment extends Model
{
    use SoftDeletes;
    // this method name should be related to the related table with id
    // laravel will convert it to blog_post_id while searching for a foreign key
    public function blogPost()
    {
        return $this->belongsTo('App\BlogPost');
    }
}
