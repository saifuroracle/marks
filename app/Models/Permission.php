<?php

namespace App;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $table = 'permissions';
    protected $primaryKey  = 'id';

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'role_has_permissions',  'permission_id', 'role_id');
    }


}
