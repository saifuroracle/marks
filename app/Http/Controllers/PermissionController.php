<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Validator;
use App\Models\Permission as Permission_c;

class PermissionController extends Controller
{

    public function managepermissions(Request $request)
    {
        $permissionsData = Permission_c::whereNull('deleted_at')->paginate(10);
        $permissions = $permissionsData->items();
        $paginator = getFormattedPaginatedArray($permissionsData);

        return view('permissions.managepermissions', compact('permissions', 'paginator'));
    }


    public function createpermissionsave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'guard_name' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with('fail', $validator->errors()->all());
        }

        DB::beginTransaction();
        try {
            Permission_c::create([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);
            DB::commit();
            return back()->with('success', ['Permission created successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('fail', [$e->getMessage()]);
        }
    }


    public function editpermissionsave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:permissions,id',
            'name' => 'required|string',
            'guard_name' => 'required|string',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with('fail', $validator->errors()->all());
        }

        DB::beginTransaction();
        try {
            $permission = Permission_c::find((int) $request->id);
            $permission->update([
                'name' => $request->name,
                'guard_name' => $request->guard_name,
            ]);

            DB::commit();
            return back()->with('success', ['Permission updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('fail', [$e->getMessage()]);
        }
    }


    public function deletepermission(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:permissions,id',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with('fail', $validator->errors()->all());
        }

        DB::beginTransaction();
        try {
            $permission = Permission_c::find((int) $request->id);
            $permission->update([
                'deleted_at'=> getNow(),
            ]);
            DB::table('role_has_permissions')->where('permission_id', (int) $request->id)->update(['deleted_at'=> getNow()]);

            DB::commit();
            return back()->with('success', ['Permission softly deleted successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('fail', [$e->getMessage()]);
        }
    }



}
