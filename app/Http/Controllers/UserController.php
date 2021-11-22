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
            'username' => 'required',
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



    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {

        $data = User::orderBy('id','DESC')->paginate(5);

        return view('users.index',compact('data'))

            ->with('i', ($request->input('page', 1) - 1) * 5);

    }



    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        $roles = Role::pluck('name','name')->all();

        return view('users.create',compact('roles'));

    }



    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $this->validate($request, [

            'name' => 'required',

            'email' => 'required|email|unique:users,email',

            'password' => 'required|same:confirm-password',

            'roles' => 'required'

        ]);



        $input = $request->all();

        $input['password'] = Hash::make($input['password']);



        $user = User::create($input);

        $user->assignRole($request->input('roles'));



        return redirect()->route('users.index')

                        ->with('success','User created successfully');

    }



    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {

        $user = User::find($id);

        return view('users.show',compact('user'));

    }



    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $user = User::find($id);

        $roles = Role::pluck('name','name')->all();

        $userRole = $user->roles->pluck('name','name')->all();



        return view('users.edit',compact('user','roles','userRole'));

    }



    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {

        $this->validate($request, [

            'name' => 'required',

            'email' => 'required|email|unique:users,email,'.$id,

            'password' => 'same:confirm-password',

            'roles' => 'required'

        ]);



        $input = $request->all();

        if(!empty($input['password'])){

            $input['password'] = Hash::make($input['password']);

        }else{

            $input = Arr::except($input,array('password'));

        }



        $user = User::find($id);

        $user->update($input);

        DB::table('model_has_roles')->where('model_id',$id)->delete();



        $user->assignRole($request->input('roles'));



        return redirect()->route('users.index')

                        ->with('success','User updated successfully');

    }



    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        User::find($id)->delete();

        return redirect()->route('users.index')

                        ->with('success','User deleted successfully');

    }

}
