<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Relation avec les commandes (orders).
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Relation avec le rôle de l'utilisateur.
     */
    public function roles()
    {
        return $this->hasMany(UserRole::class, 'user_id');
    }

    /**
     * Vérifie si l'utilisateur est un gestionnaire.
     *
     * @return bool
     */
    public function isGestionnaire()
    {
        return $this->roles()->where('role', 'gestionnaire')->exists();
    }

  
}