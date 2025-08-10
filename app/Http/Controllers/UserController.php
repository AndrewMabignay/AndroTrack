<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function index()
    {
        return view('user'); 
    }

    // USER LIST
    // public function userList() 
    // {
    //     $users = User::all()->map(function ($user) {
    //         $user->encrypted_id = encrypt($user->id);
    //         return $user;
    //     });

    //     return response()->json([
    //         'users' => $users
    //     ]);
    // }

    public function userList(Request $request) 
    {
        $users = User::paginate(5); // halimbawa: 5 users per page

        $users->getCollection()->transform(function ($user) {
            $user->encrypted_id = encrypt($user->id);
            return $user;
        });

        return response()->json([
            'users' => $users
        ]);
    }


    // USER EDIT FORM
    public function edit($encryptedId) 
    {   
        try {
            $id = decrypt($encryptedId);
            $user = User::findOrFail($id);

            return response()->json($user->makeHidden('password'));
        } catch (\Exception $e) {
            return response()->json([ 'error' => 'Invalid ID' ], 400);
        }
    }

    // USER STORE/UPDATE
    public function store(Request $request) 
    {
        $isUpdate = $request->filled('id'); // CHECK IF IT HAS AN ID OR NOT.

        $userId = $isUpdate ? decrypt($request->id) : null;
        $user = $isUpdate ? User::findOrFail($userId) : new User();

        // USER VALIDATION RULES
        $rules = [
            'profile_image' => [$isUpdate ? 'nullable' : 'required', 'image', 'mimes:jpeg,png,jpg,jfif', 'max:2048'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'middlename' => ['required', 'string', 'max:255'],
            'phone_number' => ['required', 'string', 'max:20'],
            'username' => ['required', 'string', 'max:255', 'unique:users,username' . $userId],
            'email' => ['required', 'email', 'unique:users,email,' . $userId],
            'role' => ['required', 'in:admin,manager,staff,supplier'],
            'status' => ['required', 'in:active,inactive'],
        ];

        if (!$isUpdate) {
            $rules['profile_image'] = ['image', 'mimes:jpeg,png,jpg,jfif', 'max:2048']; 
        }
        
        $request->validate($rules);

        // IMAGE HANDLING
        $userProfileImage = $user->profile_image;

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
        
        if ($request->filled('password')) {
            $user->password = $request->password;
        }

        $user->role = $request->role;
        $user->status = $request->status;

        $user->save();

        return response()->json([
            'res' => $isUpdate ? $user->username . ' has been successfully updated.' : $user->username . ' has been successfully added.'
        ]);
    }

    // TOGGLE STATUS
    public function toggleStatus($encryptedId) 
    {
        $id = decrypt($encryptedId);
        $user = User::findOrFail($id);

        $user->status = $user->status === 'active' ? 'inactive' : 'active';
        $user->save();

        return response()->json([
            'res' => 'Successfully toggle to ' . $user->status
        ]);
    }
}
