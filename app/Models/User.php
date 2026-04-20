<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
<<<<<<< HEAD
=======
use Database\Factories\UserFactory;
>>>>>>> c8ee1291fb9184a643c3c8b56e2912a6f3a04b42
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
<<<<<<< HEAD
    /** @use HasFactory<\Database\Factories\UserFactory> */
=======
    /** @use HasFactory<UserFactory> */
>>>>>>> c8ee1291fb9184a643c3c8b56e2912a6f3a04b42
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
<<<<<<< HEAD
        'id_pegawai',
        'role',
=======
>>>>>>> c8ee1291fb9184a643c3c8b56e2912a6f3a04b42
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
