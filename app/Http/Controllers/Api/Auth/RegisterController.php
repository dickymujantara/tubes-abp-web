<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    protected $status = 200;

    public function Register(Request $request)
    {
        if ($request->password == $request->conPassword) {
            $request['password'] = Hash::make($request->password);
            $store = User::create($request->all());
            $success['code'] = $this->status;
            $success['message'] = "Success";
            $success['data'] = $store;

            return response()->json($success, 200);

        }else{
            return response()->json(['code' => 400,'error'=>'Baq Request'], 400); 
        }

    }
}
