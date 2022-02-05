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
    ];

    public function points()
    {
        return $this->belongsToMany(Point::class)->withPivot('is_spare');
    }
}
