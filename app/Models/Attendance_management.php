<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance_management extends Model
{
    //
    public function employee()
    {
        return $this->hasOne(Employee::class, 'user_id', 'user_id');
    }
}
