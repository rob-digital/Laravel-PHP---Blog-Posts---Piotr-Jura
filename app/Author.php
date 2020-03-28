<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Author extends Model
{
        // this method name should be related to the related table with id
    // laravel will convert it to profile_id while searching for a foreign key
    public function profile()
    {
        return $this->hasOne('App\Profile');
    }
}
