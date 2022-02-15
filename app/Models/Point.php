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
        return $this->belongsToMany(Printer::class)->withPivot('is_spare');
    }

    public function devices()
    {
        return $this->belongsToMany(Device::class)->withPivot('ip');
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
        $points = self::select('id', 'city', 'address')->get();

        return $points->groupBy('city');
    }

    protected $casts = [
        'is_active' => 'boolean'
    ];
}
