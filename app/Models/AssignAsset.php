<?php

namespace App\Models;

use App\User;
use Illuminate\Database\Eloquent\Model;

class AssignAsset extends Model
{
    protected $casts = [
        'accessory_id' => 'array',
        'accessory_name' => 'array',

    ];
    public function employee()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function authority()
    {
        return $this->hasOne(User::class, 'id', 'authority_id');
    }

    public function asset()
    {
        return $this->hasOne('\App\Models\Asset', 'id', 'asset_id');
    }
    public function accessory()
    {
        return $this->hasOne('\App\Models\Asset', 'id', 'accessory_id');
    }
}
