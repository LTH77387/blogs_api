<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseHelper;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;


class AuthController extends Controller
{
    public function register(Request $request){
    $request->validate([
        'name'=>'required|string',
        'email'=>'required|email|unique:users,email',
        'password'=>'required|min:8|max:10',
    ]);
$user = User::create([
    'name'=>$request->name,
    'email'=>$request->email,
    'password'=>Hash::make($request->password),
]);
$token = $user->createToken('Blog')->accessToken;
return ResponseHelper::success(['token'=>$token]);

    }
    public function login(Request $request){
        $request->validate([
            'email'=>'required|email',
            'password'=>'required',
        ]);
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            $user=auth()->user();
            $token= $user->createToken('Blog')->accessToken;
            return ResponseHelper::success(['access_token'=>$token]);
        }
    }
    public function logout(Request $request){
       auth()->user()->token()->revoke();
        return ResponseHelper::success([],'Logout!');
    }
}
