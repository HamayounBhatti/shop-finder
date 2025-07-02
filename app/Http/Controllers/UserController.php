<?php
namespace App\Http\Controllers;

use App\Helpers\UploadAttachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\EmployeeController;
use App\Models\User;
use App\Models\Shop;
use App\Models\Role;
use App\Models\Branch;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role as ModelsRole;
use Carbon\Carbon;
use Psy\Readline\Hoa\Console;

class UserController extends Controller
{
    public function index()
    {
        $users = User::with('role')->with('shop')->paginate(5);
        return view('user.index',compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all();
        $shops = Shop::where('is_active','1')->get();
        return view('user.create',compact('roles','shops'));
    } 

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
     
        try {
            DB::beginTransaction();
            $request->merge([
                'hms_id' => Auth::user()->hms_id,
                'branch_id' => Auth::user()->id,
            ]);
            $request->merge([
                'password' => Hash::make($request->password) // Hash the password before storing
            ]);

            $createUser = User::create([
                'hms_id'=> $request->hms_id,
                'branch_id' => $request->branch_id,
                'name' => $request->name,
                'username' => $request->user_name,
                'email' => $request->email,
                'password' => $request->password,
                'role_id' => $request->role_id,
                'shop_id' => $request->shop_id,
            ]);
            if (!$createUser->id) {
                DB::rollBack();
                return response()->json($createUser);
            }

          
            DB::commit();
            session()->flash('success', 'New User has been created successfully !');
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors('An error occurred while creating the user. Please try again.')->withInput();
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
        $branch = User::find($id);
        $roles = Role::all();
        $shops = Shop::all();
        return view('user.edit', [
            'branch' => $branch,
            'roles' => $roles,
            'shops' => $shops,
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
    

        $validator = Validator::make($request->all(), [
            "id" => "required",
            "name" => "required",
            "user_name" => "required",
            "email" => "required",
            "role_id" => "required",
        ]);
       
        if ($validator->fails()) {
            return redirect()->back()->with('errors',$validator->errors());
        }

        if (!Auth::user() || !Auth::user()->hms_id) {
            return redirect()->back()->with('errors','Please login again.');
        }
        $request->merge([
            'hms_id' => Auth::user()->hms_id,
        ]);
            $request->merge([
                'password' => Hash::make($request->password) // Hash the password before storing
            ]);
        try {
            DB::beginTransaction();
            $user = User::find($request->id);
            
            $user->update([
                'hms_id' => $request->hms_id,
                'name' => $request->name,
                'username' => $request->user_name,
                'email' => $request->email,
				'password' => $request->password,
                'shop_id' => $request->shop_id,
                'role_id' => $request->role_id,				
            ]);

            DB::commit();
            session()->flash('success', 'User has been updated successfully !');
            return redirect()->route('user.index');
        } catch (\Exception $e) {
            DB::rollBack();
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
                $branch = Shop::find($id);
                $branch->delete();
                if ($branch) {
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
    public function getshopList()
    {
        if (!Auth::user() || !Auth::user()->hms_id) {
            return response()->json([
                "status" => FAILURE,
                "message" => LOGIN_FAILURE,
            ],400);
        }

        $branch = Shop::all();

        return response()->json([
            'status' => SUCCESS,
            'message' => GET_RECORD_SUCCESS,
            'data' => $branch,
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateStatus(Request $request)
    {

        if (!Auth::user() || !Auth::user()->hms_id) {
            return response()->json([
                "status" => FAILURE,
                "message" => 'Please login again.',
            ], 400);
        }
        try {
            DB::beginTransaction();
            $shop = Shop::find($request->id);
            
            $shop->update([
                'is_active' => $request->status,           
            ]);

            DB::commit();
            return response()->json(
                [
                    "status" => SUCCESS,
                    'message' => 'Shop Status has been updated successful'
                ],
            );
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(["status" => FAILURE, 'message' => $e], 401);
        }
    }

   
}
