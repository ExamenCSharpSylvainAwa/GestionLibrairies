<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'total_amount',
        'status',
        'payment_date',
        'payment_amount',
    ];

    protected $dates = [
        'payment_date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function books()
    {
        return $this->belongsToMany(Book::class, 'book_order')
                    ->withPivot('quantity', 'price')
                    ->withTimestamps();
    }
    public function payment()
    {
        return $this->hasOne(Payment::class);
    }
}
