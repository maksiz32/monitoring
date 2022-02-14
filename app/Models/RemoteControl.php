<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RemoteControl extends Model
{
    use HasFactory;

    protected $fillable = [
        'number',
        'description',
        'point_id'
    ];

    public function point()
    {
        return $this->belongsTo(Point::class);
    }
}
