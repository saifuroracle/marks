<?php
namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use App\Models\Role as Role_c;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;

class RoleController extends Controller
{
    public function manageroles(Request $request)
    {
        $rolesData = Role_c::whereNull('deleted_at')->paginate(10);
        $roles = $rolesData->items();
        $paginator = getFormattedPaginatedArray($rolesData);

        $permissionsData = Permission::orderBy('name','asc')->whereNull('deleted_at')->get();
        $permissions = $permissionsData->pluck('name', 'name');

        return view('roles.manageroles', compact('roles', 'paginator', 'permissions'));
    }

    public function createrolesave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            // 'permissions' => 'required',
            'guard_name' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with('fail', $validator->errors()->all());
        }


        DB::beginTransaction();
        try {
            $role = Role::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);
            // $role->syncPermissions($request->permissions);
            $permissions = DB::table('permissions')->get();
            foreach ($request->permissions as $key => $value)
            {
                DB::table('role_has_permissions')->insert(
                    [
                        'permission_id' => $permissions->where('name', $value)->pluck('id')->first(),
                        'role_id' => $role->id
                    ]
                );
            }
            DB::commit();
            return back()->with('success', ['Role created successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('fail', [$e->getMessage()]);
        }
    }


    public function editrolesave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric',
            'name' => 'required|string',
            'guard_name' => 'required|string',
            'permissions' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with('fail', $validator->errors()->all());
        }

        DB::beginTransaction();
        try {
            $role = Role::find($request->id);
            $role->update([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);
            DB::table('role_has_permissions')->where('role_id', $request->id)->update(['deleted_at'=> getNow()]);
            $permissions = DB::table('permissions')->get();
            foreach ($request->permissions as $key => $value)
            {
                DB::table('role_has_permissions')->insert(
                    [
                        'permission_id' => $permissions->where('name', $value)->pluck('id')->first(),
                        'role_id' => $request->id
                    ]
                );
            }
            DB::commit();
            return back()->with('success', ['Role updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('fail', [$e->getMessage()]);
        }
    }


    public function deleterole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:roles,id',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with('fail', $validator->errors()->all());
        }

        DB::beginTransaction();
        try {
            DB::table('roles')->where('id', (int) $request->id)->update(['deleted_at'=> getNow()]);

            return back()->with('success', ['Role softly deleted successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('fail', [$e->getMessage()]);
        }
    }


}
