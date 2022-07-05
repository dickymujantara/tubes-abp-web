<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    protected $status = 200;

    public function Register(Request $request)
    {
        try {
            if ($request->password == $request->conPassword) {
                $request['password'] = Hash::make($request->password);
                $store = User::create($request->all());
                $profile = Profile::create([
                    'id_user' => $store->id,
                    'address' => $store->address,
                    'phone_number' => $store->phoneNum,
                ]);

                $success['code'] = $this->status;
                $success['message'] = "Success";
                $success['data'] = $store;
    
                return response()->json($success, 200);
    
            }else{
                return response()->json(['code' => 400,'error'=>'Baq Request'], 400); 
            }
        } catch (\Throwable $th) {
            return response()->json(['code' => 500,'error'=>$th], 500); 
        }
    }
}
