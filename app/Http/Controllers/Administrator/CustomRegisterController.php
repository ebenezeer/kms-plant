<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class CustomRegisterController extends Controller
{
    public function store(Request $request)
    {
        $this->validate(
            $request,
            [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'role' => ['required'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
            ]
        );


        $newpass = Hash::make($request->password);

        $user = new User();
        $user->name  = $request->name;
        $user->email = $request->email;
        $user->role = $request->role;
        $user->password = $newpass;
        $user->save();


        return response()->json([
            'user'    => $user,
            'status' => 1,
            'message'   => 'Successfully Recorded'
        ], 200);


        // return User::create([
        //     'name' => $data['name'],
        //     'email' => $data['email'],
        //     'type' => $data['type'],
        //     'office_id' => $data['office_id'],
        //     'password' => Hash::make($data['password']),
        // ]);

    }
}
