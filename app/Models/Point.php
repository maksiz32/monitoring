<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model
{
    use HasFactory;

    protected $fillable = [
            'city',
            'address',
            'is_active',
            'router',
            'lan_ip',
            'vpn_ip',
            'wan_ip',
            'telephony_status',
            'provider',
            'login',
            'password',
            'contract_id'.
            'speed',
            'price',
            'login_pppoe',
            'password_pppoe',
            'ups',
        ];

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function printers()
    {
        return $this->belongsToMany(Printer::class)->withPivot('is_spare');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class)->withPivot('ip');
    }

    public function remoteControls()
    {
        return $this->hasMany(RemoteControl::class);
    }
}
