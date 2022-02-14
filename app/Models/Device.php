<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Device extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'point_id'
    ];

    public function points()
    {
        return $this->belongsTo(Point::class, 'id', 'point_id');
    }
}
