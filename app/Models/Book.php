<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Importation correcte

class Book extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'author',
        'price',
        'image',
        'description',
        'stock',
        'category',
        'archived',
    ];
    protected $attributes = [
        'archived' => false,
    ];
    protected $casts = [
        'archived' => 'boolean',
    ];

    protected $dates = ['deleted_at'];

    public function orders()
    {
        return $this->belongsToMany(Order::class)
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
}