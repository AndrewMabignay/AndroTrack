<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        return view('user'); 
    }

    public function store(Request $request) 
    {
        $user = new User();

        $userId = $request->id;

        // USER VALIDATION RULES
        $rules = [
            'profile_image' => ['required', 'image', 'mimes:jpeg,png,jpg,jfif', 'max:2048'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'middlename' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username' . $userId],
            'email' => ['required', 'email', 'unique:users,email,' . $userId],
            'password' => ['required', 'min:4', 'confirmed'],
            'role' => ['required', 'in:admin,manager,staff,supplier'],
            'status' => ['required', 'in:active,inactive'],
        ];
        
        $request->validate($rules);

        // IMAGE HANDLING
        $userProfileImage = $user->profile;

        if ($request->hasFile('profile_image')) {
            if ($userProfileImage) {
                Storage::disk('public')->delete($userProfileImage);
            }

            $userProfileImage = $request->file('profile_image')->store('profile', 'public');
        }

        // SAVE USER DATA
        $user->profile_image = $userProfileImage;
        $user->firstname = $request->firstname;
        $user->lastname = $request->lastname;
        $user->middlename = $request->middlename;
        $user->phone_number = $request->phone_number;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->role = $request->role;
        $user->status = $request->status;

        $user->save();

        return response()->json([
            'res' => 'testing'
        ]);
    }
}
