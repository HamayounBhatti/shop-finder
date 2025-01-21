<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleHasPermission extends Model
{
    protected  $table = 'role_has_permissions';
    use HasFactory;

    protected $fillable = [
        'permission_id',
        'role_id',
    ];

    public function permissions()
{
    return $this->belongsToMany(Permission::class, 'role_has_permissions');
}

// In Permission model (Permission.php)
public function roles()
{
    return $this->belongsToMany(Role::class, 'role_has_permissions');
}
}
