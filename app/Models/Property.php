<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'address',
        'user_id',
        'price',
        'number'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
