<?php
namespace App\Http\Controllers;

use DB;
use Hash;
use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;


class UserController extends Controller
{

    public function manageusers(Request $request)
    {
        $usersData = User::paginate(10);
        $users = $usersData->items();
        $paginator = getFormattedPaginatedArray($usersData);

        $rolesData = Role::orderBy('name','asc')->whereNull('deleted_at')->get();
        $roles = $rolesData->pluck('name', 'name');

        return view('users.manageusers', compact('users', 'paginator', 'roles'));
    }

    public function createusersave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|string|min:8',
            'roles' => 'required',
        ]);
        if ($validator->fails()) {
            return back()->withInput()->with('fail', $validator->errors()->all());
        }


        $input = $request->all();

        $input['password'] = bcrypt($input['password']);

        $input = Arr::except($input,array('roles'));


        DB::beginTransaction();
        try {
            $user = User::create($input);
            // $user->assignRole($request->input('roles'));
            $roles = DB::table('roles')->get();
            foreach ($request->roles as $key => $value)
            {
                DB::table('model_has_roles')->insert(
                    [
                        'role_id' => $roles->where('name', $value)->pluck('id')->first(),
                        'model_type' => 'App\Models\User',
                        'model_id' => $user->id,
                    ]
                );
            }
            DB::commit();
            return back()->with('success', ['User created successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('fail', [$e->getMessage()]);
        }
    }


    public function editusersave(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'id' => 'required|numeric|exists:users,id',
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,'.$request->id,
            'roles' => 'required'
        ]);

        if ($validator->fails()) {
            return back()->withInput()->with('fail', $validator->errors()->all());
        }

        $input = $request->all();

        if(!empty($input['password'])){

            $input['password'] = bcrypt($input['password']);

        }else{
            $input = Arr::except($input,array('password'));
        }

        $input = Arr::except($input,array('roles'));

        $user = User::find($request->id);

        DB::beginTransaction();
        try {
            $user->update($input);
            // $user->assignRole($request->input('roles'));
            DB::table('model_has_roles')->where('model_id', (int) $request->id)->update(['deleted_at' => getNow()]);
            $roles = DB::table('roles')->get();
            foreach ($request->roles as $key => $value)
            {
                DB::table('model_has_roles')->insert(
                    [
                        'role_id' => $roles->where('name', $value)->pluck('id')->first(),
                        'model_type' => 'App\Models\User',
                        'model_id' => $request->id,
                    ]
                );
            }

            DB::commit();
            return back()->with('success', ['User updated successfully']);
        } catch (\Exception $e) {
            DB::rollback();
            return back()->withInput()->with('fail', [$e->getMessage()]);
        }
    }




}
