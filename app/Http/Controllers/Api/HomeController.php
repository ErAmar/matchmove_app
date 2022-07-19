<?php
#app\Http\Controllers\Api\HomeController.php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;
use Validator;

class HomeController extends Controller
{
    public function index(Request $request) {
        $token = $request->bearerToken();
        $users = User::where('api_token',$token)->select('id', 'name', 'email', 'api_token', 'expires_at')->first();

        if($users->count() && $users['status'] == 1 &&  $users['expires_at'] >= date("Y-m-d") ) { 
            return response()->json(['status' => 'Success', "data" => $users], 200);
        } else{ 
            return response()->json(['status' => 'Invalid Token'], 401);
        }
    }
}