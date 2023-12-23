<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'age', 'points', 'address'];

    protected $casts = [
        'points' => 'integer',
        'age' => 'integer',
    ];

    public function scopeOrderByPointsDesc($query)
    {
        return $query->orderBy('points', 'desc');
    }
}
