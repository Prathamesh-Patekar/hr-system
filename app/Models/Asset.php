<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $fillable = [
        'os','imei','status','name','device','device_sr', 'processor','ram', 'storage_type','ssd', 'hdd','description',
    ];
    public function accessory()
    {
        return $this->hasOne('\App\Models\AssignAsset', 'asset_id', 'id');
    }
}
