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
    ];

    public function point()
    {
        return $this->hasOne(Point::class);
    }
}
