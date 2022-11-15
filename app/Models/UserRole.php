<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserRole extends Model
{
    protected $guarded = [];

    public function role()
    {
        return $this->hasOne('App\Models\Role', 'id', 'role_id');
    }
    public function user()
    {
        return $this->hasOne('App\User', 'id','user_id');
    }
    protected $fillable = [
        'user_id', 'role_id',
    ];
}
