<?php

namespace App\Scopes;

use Illuminate\Database\Eloquent\Scope;

class LatestScope implements Scope
{
    public function apply( $builder,  $model)
    {
        $builder->orderBy($model::CREATED_AT, 'desc');
    }
}
