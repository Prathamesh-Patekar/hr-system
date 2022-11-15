<?php

namespace App\Models;

use App\User;
use App\Holiday_employee;
use App\TrainingInvite;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    public function userrole()
    {
        return $this->hasOne('App\Models\UserRole', 'user_id', 'id');
    }

    public function employeeLeaves()
    {
        return $this->hasMany('App\EmployeeLeaves', 'user_id', 'user_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    protected $fillable = [
        'name'    ,
        'email'   ,
        'photo'   ,
        'mname'  ,
        'lname'    ,
        'personal_email'  ,
        'code'    ,
        'status'   ,
        'gender'   ,
        'date_of_birth'   ,
        'date_of_joining'    ,
        'number'    ,
        'mnumber_two'    ,
        'qualification'    ,
        'emerg_name'    ,
        'emerg_rel'  ,
        'emergency_number' ,
        'pan_number'    ,
        'aadhar_number'    ,
        'esic_number'  ,
        'father_name'   ,
        'date_of_joining'  ,
        'current_address'    ,
        'permanent_address'   ,
        'offer_acceptance'    ,
        'probation_period'    ,
        'date_of_confirmation'  ,
        'department'    ,
        'salary'    ,
        'account_number'   ,
        'bank_name'  ,
        'ifsc_code'   ,
        'pf_account_number'   ,
        'un_number'   ,
        'esic_number'    ,
        'pf_status'    ,
        'user_id',
    ];
    public function TrainingInvite()
    {
        return $this->hasMany(TrainingInvite::class, 'user_id', 'user_id');
    }

    public function holiday_employee()
    {
        return $this->hasOne(Holiday_employee::class, 'user_id', 'user_id');
    }

}
