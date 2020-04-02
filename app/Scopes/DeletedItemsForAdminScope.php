<?php

namespace App\Scopes;

use Auth;
use Illuminate\Database\Eloquent\Scope;

class DeletedItemsForAdminScope implements Scope
{
    public function apply( $builder,  $model)
    {
      if (Auth::check() && Auth::user()->is_admin) {
          $builder->withTrashed();
      }
    }
}
