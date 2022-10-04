<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required',
            'lastname' => 'required',
            'username' => 'required',
            'password' => 'required|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        $user = new User([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'username' => $request->username,
        ]);
        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json([
            'message' => 'User successfully registered',
            'user' => $user,
        ], 200);
    }
}