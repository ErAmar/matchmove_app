<?php
#app\Http\Controllers\Api\HomeController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;

class RegisterController extends Controller
{
    public function index(Request $request) {

        $validator = Validator::make($request->all(), [ 
            'name' => 'required',
            'status' => 'required',
            'email' => 'required',
        ]);

        if ($validator->fails()) { 
            return response()->json(['error'=>$validator->errors()], 401);
        }
        else{
            $length_of_string = rand(8,24);
            $str_result = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';
            $string_g = substr(str_shuffle($str_result), 0, $length_of_string);
            $password = \Hash::make( $string_g ) ; 

            $data = $request->input();
            $user = new User;
            $user->name = $data['name'];
            $user->email = $data['email'];
            $user->status = $data['status'];
            $user->expires_at = date("Y-m-d", strtotime("+30 days"));
            $user->password = $password;
            $user->save();

            if(Auth::attempt([ 'email' => $request->email, 'password' => $string_g ])){ 
                $token = auth()->user()->createApiToken(); #Generate token
                return response()->json(['status' => 'Token Generated', 'token' => $token ], 200);
            } else { 
                return response()->json(['status'=>'Unauthorised'], 401);
            }
        }
    }
}