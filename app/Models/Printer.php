<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Printer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'serial_number',
        'is_spare',
        'point_id',
    ];

    public function point()
    {
        return $this->belongsTo(Point::class);
    }

    protected $casts = [
        'is_spare' => 'boolean'
    ];
}
