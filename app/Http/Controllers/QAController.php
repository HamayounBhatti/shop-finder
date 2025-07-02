<?php

namespace App\Http\Controllers;

use App\Models\Claim;
use App\Models\Image;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QAController extends Controller
{
    public function index()
    {
        $claims=Claim::where('status','!=',0)
                        ->whereHas('shops', function($query){
                            $query->where('is_active', 1);
                        })
                        ->with('shops')->paginate(5);
        return view('qa.index',compact('claims'));
    }
    public function submitRecord(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => $request->status,
        ]);
        try {
            DB::beginTransaction();
            $claim = Claim::find($request->claimId);
            if($request->status == 2){
                $claim->update([
                    'status' => $request->status,
                    'qa_message' => $request->qa_message,
                    'is_closed' => 1,         
                ]);
            }else{
                $claim->update([
                    'status' => $request->status,
                    'qa_message' => $request->qa_message,      
                ]);
            }
            DB::commit();
            session()->flash('success', 'Claim Record has been updated successfully !');
            return redirect()->route('qa.claims');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errors',$e);
        }


    }
    public function receivedClaim(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'is_received' => $request->is_received,
            'received_date_and_time' => $request->received_date_and_time,
        ]);
        try {
            DB::beginTransaction();
            $claim = Claim::find($request->receivedId);
                $claim->update([
                    'status' => 5,
                    'receiving_remarks' => $request->received_remarks,
                    'is_received' => $request->is_received,  
                    'received_date_and_time' => $request->received_date_and_time,      
                ]);
            DB::commit();
            session()->flash('success', 'Claim Received successfully !');
            return redirect()->route('qa.claims');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errors',$e);
        }


    }
    public function gallary($id)
    {
        // Fetch all images from the database
        $defect_images = Image::where('claim_id',$id)->get();

        return view('qa.gallary', compact('defect_images'));
    }
    public function createReceivedClaim($id){
        $claim=Claim::find($id);
        return view('qa.received-product',compact('claim'));
    }
    public function createSubmitRecord($id){
        $claim=Claim::find($id);
        return view('qa.submit-record',compact('claim'));
    }
}
