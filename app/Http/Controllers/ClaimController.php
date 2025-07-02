<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\Claim;
use App\Models\Image;
use App\Models\Role;
use App\Models\User;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class ClaimController extends Controller
{
    public function index()
    {
        if(Auth::user()->role->name == 'Shop'){
                $claims = Claim::where('status','!=',2)
							   ->where('is_closed','!=','1')
                               ->where('shop_id',Auth::user()->shop_id)
                               ->whereHas('shops', function($query){
                                   $query->where('is_active', 1);
                                })
                               ->with('shops')->paginate(5);
                               
            }elseif(Auth::user()->role->name == 'Super Admin'){
                $claims = Claim::where('status','!=',2)
							   ->where('is_closed','!=','1')
                               ->whereHas('shops', function($query){
                                $query->where('is_active', 1);
                                })
                               ->with('shops')->paginate(5);
            }else{
                $claims = Claim::where('status','!=',2)
							   ->where('is_closed','!=','1')
							   ->whereHas('shops', function($query){
								  $query->where('is_active', 1);
							     })
							   ->with('shops')->paginate(5);
            }
            $imageUrl = null;
        if(!$claims){
            $claim_id = Claim::find($claims[0]->id);
            $imageUrl = $claim_id->invoice_image ? asset('storage/' . $claim_id->invoice_image) : null;
        }
        return view('claims.index',compact('claims','imageUrl'));
    }
    public function closedClaim()
    {
        if(Auth::user()->role->name == 'Shop'){
            $claims = Claim::where('is_closed',1)
                           ->where('shop_id',Auth::user()->shop_id)
                           ->whereHas('shops', function($query){
                               $query->where('is_active', 1);
                            })
                           ->with('shops')->paginate(5);
        }elseif(Auth::user()->role->name == 'Super Admin'){
            $claims = Claim::where('is_closed',1)
                           ->whereHas('shops', function($query){
                            $query->where('is_active', 1);
                            })
                           ->with('shops')->paginate(5);
        }else{
            $claims = Claim::where('is_closed',1)
                           ->whereHas('shops', function($query){
                                $query->where('is_active', 1);
                            })
                            ->with('shops')->paginate(5);
        }
        return view('claims.closed',compact('claims'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->role->name == 'Shop'){
            $shops = Shop::where('id',Auth::user()->shop_id)->get();
        }else{
            $shops = Shop::all();
        }
        
        return view('claims.create',[
                'shops' => $shops,
            ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'article_number' => 'required|numeric',
        'name' => 'required|string',
        'invoice' => 'required|numeric',
        'purchase_date' => 'required|date',
        'article_price' => 'required|numeric',
        'period' => 'required|string',
        'customer_name' => 'required|string',
        'customer_address' => 'required|string',
        'customer_email' => 'required|email',
        'ptcl_number' => 'required|string',
        'cell' => 'required|string',
        'shop_manager' => 'required|string',
        'shop_id' => 'required|numeric',
        'invoice_image.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        'defect_image.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
    ]);

    // Add custom validation for purchase date
    $validator->after(function ($validator) use ($request) {
        try {
            $purchaseDate = Carbon::parse($request->purchase_date);
            if ($purchaseDate->lt(Carbon::now()->subDays(31))) {
                $validator->errors()->add('purchase_date', 'The Purchase Date of invoice must be within the last 30 days.');
            }
        } catch (\Exception $e) {
            $validator->errors()->add('purchase_date', 'Invalid purchase date.');
        }
    });

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    if (!Auth::check() || !Auth::user()->hms_id) {
        return redirect()->back()->withErrors(['auth' => 'Please login again.']);
    }

    try {
        DB::beginTransaction();

        $role = Role::where('hms_id', Auth::user()->hms_id)
            ->where('slug', 'shop')
            ->pluck('id')
            ->first();

        if (!$role) {
            return redirect()->back()->withErrors(['role' => 'Shop role not found.']);
        }

        $request->merge([
            'hms_id' => Auth::user()->hms_id,
        ]);

        $invoiceImagePath = null;
        if ($request->hasFile('invoice_image')) {
            $invoiceImagePath = $request->file('invoice_image')->store('images', 'public');
        }

        $claim = Claim::create([
            'hms_id' => $request->hms_id,
            'article_number' => $request->article_number,
            'name' => $request->name,
            'invoice' => $request->invoice,
            'purchase_date' => $request->purchase_date,
            'article_price' => $request->article_price,
            'period' => $request->period,
            'customer_name' => $request->customer_name,
            'customer_address' => $request->customer_address,
            'customer_email' => $request->customer_email,
            'ptcl_number' => $request->ptcl_number,
            'cell' => $request->cell,
            'shop_manager' => $request->shop_manager,
            'shop_id' => $request->shop_id,
            'proposed_status' => $request->proposed_status,
            'color' => $request->color,
            'size' => $request->size,
            'invoice_image' => $invoiceImagePath,
        ]);

        if ($request->hasFile('defect_image')) {
            foreach ($request->file('defect_image') as $image) {
                $path = $image->store('images', 'public');

                Image::create([
                    'claim_id' => $claim->id,
                    'defect_image' => $path,
                ]);
            }
        }

        DB::commit();
        return redirect()->route('claim.index')->with('success', 'New Claim has been created successfully!');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->withErrors(['error' => $e->getMessage()])->withInput();
    }
}
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $branch = Claim::find($id);
        $shops = Shop::all();
        return view('claims.edit', [
            'branch' => $branch,
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
            'article_number' => 'required',
            'name' => 'required',
            'invoice' => 'required',
            'purchase_date' =>  [
                'required',
                'date',
                function ($attribute, $value, $fail) {
                    $purchaseDate = Carbon::parse($value);
                    $now = Carbon::now();
        
                    if ($purchaseDate->lt($now->subDays(30))) {
                        $fail("The Purchase Date of invoice must be within the last 30 days.");
                    }
                },
            ],
            'article_price' => 'required',
            'period' => 'required',
            'customer_name' => 'required',
            'customer_address' => 'required',
            'customer_email' => 'required',
            'ptcl_number' => 'required',
            'cell' => 'required',
			'shop_manager' => 'required',
            'shop_id' => 'required',
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

        try {
            DB::beginTransaction();
            $claim = Claim::find($request->id);
            
            $claim->update([
                'hms_id' => $request->hms_id,
                'article_number' => $request->article_number,
                'name' => $request->name,
                'invoice' => $request->invoice,
                'purchase_date' => $request->purchase_date,
                'article_price' => $request->article_price,
                'period' => $request->period,
                'customer_name' => $request->customer_name,
                'customer_address' => $request->customer_address,
                'customer_email' => $request->customer_email,
                'ptcl_number' => $request->ptcl_number,
                'cell' => $request->cell,
				'shop_manager'=>$request->shop_manager,
                'shop_id' => $request->shop_id,
                'proposed_status' => $request->proposed_status,
                'color' => $request->color,
                'size' => $request->size,
                'inward_gate_pass' => $request->inward_gate_pass,        
            ]);

            DB::commit();
            session()->flash('success', 'Your Claim has been updated successfully !');
            return redirect()->route('claim.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errors',$e);
        }
    }
    public function createSubmitRecord($id){
        $claim=Claim::find($id);
        return view('claims.submit-create',compact('claim'));
    }
    public function submitRecord(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => $request->status,
            'message' => $request->message,
        ]);

        try {
            DB::beginTransaction();
            $claim = Claim::find($request->claimId);
            $claim->update([
                'status' => $request->status,
                'message' => $request->message,             
            ]);
            DB::commit();
            session()->flash('success', 'Claim has been Submitted successfully !');
            return redirect()->route('claim.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errors',$e);
        }


    }
	  public function locallyClosed($id){
        $claim=Claim::find($id);
        return view('claims.locally-closed',compact('claim'));
    }
    public function locallyClosedClaim(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'status' => $request->status,
            'message' => $request->message,
        ]);

        try {
            DB::beginTransaction();
            $claim = Claim::find($request->claimId);
            $claim->update([
				'status' => 6,
                'is_closed' => $request->status,
                'message' => $request->message,             
            ]);
            DB::commit();
            session()->flash('success', 'Claim has been Submitted successfully !');
            return redirect()->route('claim.index');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errors',$e);
        }


    }
	    public function getClaimById($id)
{
    $claim = Claim::with('shops')->find($id);

    if (!$claim) {
        return response()->json(['message' => 'Claim not found'], 404);
    }

    return response()->json($claim);
}

}
