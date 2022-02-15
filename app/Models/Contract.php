<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'contracts_master',
        'speed',
        'price',
        'login_pppoe',
        'password_pppoe',
        'point_id'
    ];

    public function point()
    {
        return $this->belongsTo(Point::class);
    }
}
