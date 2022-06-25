<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Auth;

class ProfileController extends Controller
{
    protected $status = 200;

    public function updateProfile(Request $request,$id)
    {
        try {
            $updateUser = User::where(['id' => $id])->update([
                "email" => $request->email,
                "name" => $request->name,
                "address" => $request->address,
            ]);

            $updateProfile = Profile::where(['id_user' => $id])->update([
                "phone_number" => $request->phoneNumber,
                "address" => $request->address,
            ]);
            
            $user = User::select()->where(['id' => $id])->first();
            $profile = Profile::select()->where(['id_user' => $id])->first();

            $success['code'] = $this->status;
            $success['message'] = "Success";
            $success['data'] = $user;
            $success['data']['profile'] = $profile;

            return response()->json($success, 200);
        } catch (\Exception $e) {
            return response()->json(['code' => 500,'error'=>$e->getMessage()], 500); 
        }
    }

    public function getProfile($id)
    {
        try {
            $profile = Profile::select()->where(['id_user' => $id])->first();

            $success['code'] = $this->status;
            $success['message'] = "Success";
            $success['data'] = $profile;


            return response()->json($success, 200);
        } catch (\Throwable $th) {
            return response()->json(['code' => 500,'error'=>$th], 500); 
        }
    }

}
