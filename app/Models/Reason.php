<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reason extends Model
{
    //
    public function attendance_management()
    {
        return $this->hasMany(Attendance_management::class, 'id', 'attend_id');
    }
    public function employee()
    {
        return $this->hasOne(Employee::class, 'id', 'user_id');
    }

}
