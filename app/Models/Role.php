<?php

namespace App\Models;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $primaryKey  = 'id';

    protected $fillable = [
        'name',
        'guard_name',
        'created_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'id' => 'integer',
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'model_has_roles', 'role_id',  'model_id');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'role_has_permissions', 'role_id',  'permission_id');
    }

    public function getPermissionsCommaSeperatedAttribute()
    {
        $permissions = $this->permissions()->wherePivot('deleted_at', null)->get();
        $arr = [];
        foreach ($permissions as $key => $item)
        {
            $arr[] = $item->name;
        }
        $str = implode(", ",$arr) ?? '';
        return $str;
    }

    public function getPermissionsListAttribute()
    {
        $permissions = $this->permissions()->wherePivot('deleted_at', null)->get();
        $arr = [];
        foreach ($permissions as $key => $item)
        {
            $arr[] = $item->name;
        }
        return $arr;
    }

    protected $appends = ['permissions_comma_seperated', 'permissions_list'];

}
