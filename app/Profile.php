<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
        // this method name should be related to the related table with id
    // laravel will convert it to author_id while searching for a foreign key
    public function author()
    {
        return $this->belongsTo('App\Author');
    }
}
