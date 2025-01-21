<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Claim;
use App\Models\Role;
use App\Models\User;
use App\Models\Shop;
use Illuminate\Support\Facades\Hash;

class DistributionController extends Controller
{
    public function index()
    {
        $claims = Claim::where('status',4)
        ->where('is_closed',0)
        ->whereHas('shops', function($query){
            $query->where('is_active', 1);
        })
        ->with('shops')->get();
        return view('distribution.index',compact('claims'));
    }
    public function repair()
    {
        $claims = Claim::where('status',3)
        ->where('is_closed',0)
        ->whereHas('shops', function($query){
            $query->where('is_active', 1);
        })
        ->with('shops')->get();
        return view('distribution.repair',compact('claims'));
    }

    public function getclaimList()
    {
        if (!Auth::user() || !Auth::user()->hms_id) {
            return response()->json([
                "status" => FAILURE,
                "message" => LOGIN_FAILURE,
            ],400);
        }
        $branch = Claim::where('status',4)
                        ->where('is_closed',0)
                        ->whereHas('shops', function($query){
                            $query->where('is_active', 1);
                        })
                        ->with('shops')->get();
        // $branch = Claim::with('shops')->get();
        return response()->json([
            'status' => SUCCESS,
            'message' => GET_RECORD_SUCCESS,
            'data' => $branch,
        ]);
    }
    public function getRepairList()
    {
        if (!Auth::user() || !Auth::user()->hms_id) {
            return response()->json([
                "status" => FAILURE,
                "message" => LOGIN_FAILURE,
            ],400);
        }
        $branch = Claim::where('status',3)
                        ->where('is_closed',0)
                        ->whereHas('shops', function($query){
                            $query->where('is_active', 1);
                        })
                        ->with('shops')->get();
        // $branch = Claim::with('shops')->get();
        return response()->json([
            'status' => SUCCESS,
            'message' => GET_RECORD_SUCCESS,
            'data' => $branch,
        ]);
    }
    public function submitRecord(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => $request->status,
        ]);
        try {
            DB::beginTransaction();
            $claim = Claim::find($request->claimId);
            
            $claim->update([
                'status' => $request->status,
                'distribution_message' => $request->distribution_message,
                'is_closed' => 1,            
            ]);
            DB::commit();
            if(url()->previous() == 'http://192.168.0.106:8000/distribution/repairs'){
                session()->flash('success', 'Done successfully !');
                return redirect()->route('distribution.repairs');
            }else{
                session()->flash('success', 'Done successfully !');
                return redirect()->route('distribution.claims');   
            }

        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errors',$e);
        }


    }
    public function createSubmitRecord($id){
        $claim=Claim::find($id);
        return view('distribution.submit-record',compact('claim'));
    }
}
