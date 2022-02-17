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
            'ups',
        ];

    public function contract()
    {
        return $this->hasOne(Contract::class);
    }

    public function printers()
    {
        return $this->hasMany(Printer::class);
    }

    public function devices()
    {
        return $this->hasMany(Device::class);
    }

    public function remotes()
    {
        return $this->hasMany(RemoteControl::class, 'point_id', 'id');
    }

    /**
     * @return mixed
     */
    public static function pointsByCity()
    {
        $points = self::select('id', 'city', 'address')->where('is_active', true)->orderBy('id')->get();

        return $points->groupBy('city');
    }

    protected $casts = [
        'is_active' => 'boolean',
        'telephony_status' => 'boolean'
    ];
}
