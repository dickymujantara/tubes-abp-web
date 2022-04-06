<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Models\User;
use App\Models\Profile;
use Validator;

class LoginController extends Controller
{
    protected $status = 200;

    public function login(Request $request)
    {
        try {
            if(Auth::attempt(['username' => request('username'), 'password' => request('password')])){ 
                $user = Auth::user();
                $success['code'] = $this->status;
                $success['message'] = "Success";
                $success['data']['access_token'] =  $user->createToken('2')->accessToken;
                $success['data']['token_type'] = 'bearer';
                $success['data']['user'] = $user;
    
                return response()->json($success, $this->status);
    
            } else{ 
                return response()->json(['code' => 401,'error'=>'Unauthorized'], 401); 
            } 
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
