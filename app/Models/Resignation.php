<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Resignation extends Model
{
    //

    public function userrole()
    {
        return $this->hasOne('App\Models\User', 'user_id', 'id');
    }


       public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'user_id');
    }
}
