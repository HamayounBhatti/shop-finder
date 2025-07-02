<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
		'hms_id',
        'branch_id',
        'name',
        'username',
        'email',
        'password',
        'role_id',
        'shop_id',
		'remember_token',
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
        'password' => 'hashed',
    ];
    public function hms()
    {
        return $this->belongsTo(Hms::class, 'hms_id', 'id');
    }
    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
    
    public function shop()
    {
        return $this->belongsTo(Shop::class, 'shop_id', 'id');
    }

    public function hasPermission($permission)
    {
        // Example: Check permission through roles (adjust logic based on your system)
        return $this->getPermissions()->contains('name', $permission);
    }

    public function getPermissions()
    {
        // Retrieve permissions dynamically through roles
        return $this->role()->with('permissions')->get()
                    ->pluck('permissions')
                    ->flatten()
                    ->unique('id');
    }
    
}
