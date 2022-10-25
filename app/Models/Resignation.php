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
        return $this->hasOne(Employee::class, 'id', 'employee_id');
    }

    public function employee_form()
    {
        return $this->hasOne(Employee_form::class, 'employee_id', 'user_id');
    }
}
