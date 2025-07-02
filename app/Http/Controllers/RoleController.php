<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use App\Models\{
    User,
    Permission,
    RoleHasPermission
};
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Str;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
        // $this->middleware('permission:roles_read|roles_write|roles_create|roles_delete', ['only' => ['index','store','getRolesList','getUsersList']]);
        // $this->middleware('permission:roles_create', ['only' => ['create','store']]);
        // $this->middleware('permission:roles_write', ['only' => ['edit','update']]);
        // $this->middleware('permission:roles_delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = Role::withCount('users')
            ->where('roles.hms_id', Auth::user()->hms_id)->paginate(5);
        $pageConfigs = ['pageHeader' => false,];
        return view('roles.index', [
            'roles' => $roles,
            'pageConfigs' => $pageConfigs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $permissions = Permission::all();
            
        //$permissions = Permission::get()->pluck('name', 'id');
        return view('roles/create', compact('permissions'));
        // return response()->json([
        //     'status' => SUCCESS,
        //     'message' => GET_RECORD_SUCCESS,
        //     'data' => $view->render(),
        // ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\RoleRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $hms_id = Auth::user()->hms_id;
        $branch_id = Auth::user()->branch_id;
        if (!Auth::user() || !$hms_id) {
            return redirect()->back()->with('errors','login fail.');
        }
        try {
            DB::beginTransaction();
            $permissions = $request->input('permissions', []);
            $permissions = array_map('intval', $permissions);
            $role = Role::create([
                'name' => $request->input('name'),
                'slug' => Str::slug($request->input('name')),
                'hms_id' => Auth::user()->hms_id,
                'branch_id' =>Auth::user()->branch_id,
            ]);
            
            if ($request->has('permissions') && !empty($request->input('permissions'))) {
                $role->permissions()->sync($request->input('permissions'));  // Sync permissions
            } else {
                DB::rollBack();
                return redirect()->back()->with('errors', 'No permissions provided.');
            }
                    DB::commit();
                    session()->flash('success', 'Permissions Added Against The Role !');
                    return redirect()->route('roles.index'); 
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug($e);
            return redirect()->back()->with('errors',$e);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $role = Role::find($id);
        // $permissions = CustomerPermissionModel::join('hms_has_permission','hms_has_permission.permissions_id', '=', 'permissions.id')
        //     ->where('hms_has_permission.hms_id', Auth::user()->hms_id)
        //     ->get()->pluck('permissions.name', 'permissions.id');
        $permissions = Permission::all();
        //$permissions = Permission::get()->pluck('name', 'id');
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
            ->pluck('role_has_permissions.permission_id','role_has_permissions.permission_id')
            ->all();
            return view('roles/edit', compact('role','permissions','rolePermissions'));
       
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\RoleRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $hms_id = Auth::user()->hms_id;
        if (!Auth::user() || !$hms_id) {
            return response()->json([
                "status" => FAILURE,
                "message" => LOGIN_FAILURE,
            ],400);
        }
        try {
            DB::beginTransaction();
            $role = Role::findById($id);
            $role->name = $request->input('name');
            $role->save();
            $role->permissions()->sync($request->input('permissions'));
            if ($role) {
                DB::commit();
                session()->flash('success', 'Permissions and Role Updated !');
                return redirect()->route('roles.index'); 
            } else {
                DB::rollBack();
                return redirect()->back()->with('errors', 'Update Failed');
            }
        } catch (\Exception $e) {
            DB::rollBack();
            Log::debug($e);
            return redirect()->back()->with('errors',$e);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (!Auth::user() || !Auth::user()->hms_id) {
            return response()->json([
                "status" => FAILURE,
                "message" => LOGIN_FAILURE,
            ],400);
        }

        try {
            DB::beginTransaction();
            if ($id) {
                $role = Role::where('id',$id)->delete();
                if ($role) {
                    DB::commit();
                    return response()->json([
                        "status" => SUCCESS,
                        'message' => DELETE_RECORD_SUCCESS
                    ]);
                }else{
                    DB::rollBack();
                    return response()->json([
                        "status" => FAILURE,
                        'message' => DELETE_RECORD_FAILURE
                    ]);
                }

            } else {
                return response()->json([
                    "status" => FAILURE,
                    'message' => RECORD_NOT_FOUND
                ]);
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                "status" => FAILURE,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function getUsersList()
    {
        if (!Auth::user() || !Auth::user()->hms_id) {
            return response()->json([
                "status" => FAILURE,
                "message" => LOGIN_FAILURE,
            ],400);
        }

        $usersWithRoles = User::where('hms_id', Auth::user()->hms_id)
            ->select('id', 'email', 'name', 'username')
            ->with('roles:id,name')->get()->toArray();
        return response()->json([
            'status' => SUCCESS,
            'message' => GET_RECORD_SUCCESS,
            'data' => $usersWithRoles,
        ]);
    }
}
