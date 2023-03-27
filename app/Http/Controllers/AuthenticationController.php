<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthenticationController extends Controller
{
    public function signup(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'name' => 'required|string|regex:/^[a-zA-Z\s]*$/',
            'email' => 'required|unique:users|email',
            'password' => 'required|string|min:8',     
        ]);
        if($validator->fails())
        {
            return response()->json([
                'Message' => 'Sign-up failed.',
                'Error' => $validator->errors(),
            ]);
        }
        $new_user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        return response()->json([
            'Message' => 'Signup success.',
            'User' => $new_user
        ]);
    }
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'email' => 'required|exists:users,email',
            'password' => 'required|string|min:8',
        ]);
        if($validator->fails())
        {
            return response()->json([
                'Message' => 'Login Failed',
                'Errors' => $validator->errors(),
            ],401);  
        }
        else{
            $user = User::Where('email','=',$request->email)->first();
            $valid = Hash::check($request->password,$user->password);
            if($valid)
            {
                $token = $user->createToken('Bearer Token')->accessToken;
                return response()->json([
                    'Message' => 'Login success.',
                    'AccessToken' => $token,
                ]);
            }
            else
            {
                $token = $user->createToken('Bearer Token')->accessToken;
                return response()->json([
                    'Message' => 'Login failed.',
                    'Error' => 'Invalid Credentials'
                ]);
            }
        }
    }
}
