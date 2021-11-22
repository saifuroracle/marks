<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $primaryKey  = 'id';

    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];


    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions',  'permission_id', 'role_id');
    }


}
