<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BlogPost extends Model
{
    // protected $table = 'blogpost';
    protected $fillable = ['title', 'content'];
}
