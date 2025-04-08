<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegesterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class AuthController extends Controller
{
    public function register(RegesterRequest $request) {

        $user = User::create([
            'name'=>$request->name ,
            'email'=>$request->email ,
            'password'=> Hash::make($request->password)
        ]) ;

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json([
            'access_token' => $token,
            'token_type' => 'Bearer',
            'user'=>$user ,
            'message'=>'Register successfully'
        ],200);
    }

    public function login(LoginRequest $request) {
        $user = User::where('email',$request->email)->first();
        if($user){
            if (Hash::check($request->password , $user->password ) ){
                $token = $user->createToken('auth_token')->plainTextToken;
                return response()->json([
                   'access_token' => $token,
                   'token_type' => 'Bearer',
                   'user'=>$user ,
                   'message'=>'login success'
                ],200);
            }else{
                return response()->json([
                    'message'=>'password not match'
                ],403);
            }
        }else{
            return response()->json([
                'message'=>'user not found'
            ]);
        }

    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out']);
    }

}
