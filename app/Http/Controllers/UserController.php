<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Hash;
use Illuminate\Http\Request;
use function PHPUnit\Framework\returnCallback;

class UserController extends Controller
{
    public function profile(){

        $user = auth()->user();
        $profile = $user->entity();

        return view('user.profile', compact('profile'));
    }

    public function changePassword(Request $request)
    {
        $user = auth()->user();

        $rules = ['newpassword' => 'required|string|min:6|max:24|confirmed'];

         if (!$user->hasDefaultPassword()) {
             $rules['oldpassword'] = 'required|current_password';
         }

        $validator = Validator::make($request->all(), $rules);

         if ($validator->fails()) {
             return redirect()->back()
                 ->with('error', $validator->errors()->first());
         }

        $validated = $validator->validated();

        $user->update(['password' => Hash::make($validated['newpassword'])]);

        return redirect()->back()->with('success', 'Password berhasil diperbarui!');
    }


}
