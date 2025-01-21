<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $branch = User::find(Auth::user()->id);
        return view('profile.edit', [
            'branch' => $branch,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            "id" => "required",
            "name" => "required",
            "user_name" => "required",
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
            $user = User::find($request->id);
            
            $user->update([
                'hms_id' => $request->hms_id,
                'name' => $request->name,
                'username' => $request->user_name,        
            ]);

            DB::commit();
            session()->flash('success', 'Profile has been updated Successfully !');
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errors',$e);
        }

    }
    public function password(Request $request): View
    {
        $branch = User::find(Auth::user()->id);
        return view('profile.change-password', [
            'branch' => $branch,
        ]);
    }
    public function updatePassword(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'password' => 'required|min:8|confirmed',
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
            $user = User::find($request->id);
            
            $user->update([
                'password' => bcrypt($request->password),       
            ]);

            DB::commit();
            session()->flash('success', 'Password updated Successfully !');
            return redirect()->route('dashboard');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('errors',$e);
        }

    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
