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

class ShopController extends Controller
{
    public function index()
    {
        $shops = Shop::paginate(5);
        return view('shop.index',compact('shops'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('shop.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

     
        if (!Auth::user() || !Auth::user()->hms_id) {
            return redirect()->back()->with('errors','Please login again.');
        }
     
        try {
            DB::beginTransaction();
            $request->merge([
                'hms_id' => Auth::user()->hms_id,
            ]);

            $createShop = Shop::create([
                'name' => $request->name,
                'shop_number' => $request->shop_number,
                'address' => $request->address,
            ]);
       
            if (!$createShop->id) {
                DB::rollBack();
                return redirect()->back()->with('errors',$createShop);
            }

          
            DB::commit();
            session()->flash('success', 'New Shop has been created successfully !');
            return redirect()->route('shop.index');
        } catch (\Exception $e) {
            DB::rollBack();
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
        $branch = Shop::find($id);
     
        return view('shop.edit', [
            'branch' => $branch,
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
            "shop_number" => "required",
            "address" => "required",
        ]);
       
        if ($validator->fails()) {
            return redirect()->back()->with('errors',$validator->errors());
        }

        if (!Auth::user() || !Auth::user()->hms_id) {
            return redirect()->back()->with('errors',$validator->errors());
        }
        $request->merge([
            'hms_id' => Auth::user()->hms_id,
        ]);

        try {
            DB::beginTransaction();
            $shop = Shop::find($request->id);
            
            $shop->update([
                'hms_id' => $request->hms_id,
                'name' => $request->name,
                'shop_number' => $request->shop_number,
                'address' => $request->address,              
            ]);

            DB::commit();
            session()->flash('success', 'Shop has been updated successfully !');
            return redirect()->route('shop.index');
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
            return redirect()->back()->with('errors','Please login again.');
        }
        try {
            DB::beginTransaction();
            $shop = Shop::find($request->id);
            
            $shop->update([
                'is_active' => $request->is_active,           
            ]);

            DB::commit();
            session()->flash('success', 'Shop Status Has Been Updated Successfully !');
            return redirect()->route('shop.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errors',$e);
        }
    }
    public function createSubmitRecord($id){
        $shop = Shop::find($id); 
        return view('shop.update-status',compact('shop'));
    }

   
}
