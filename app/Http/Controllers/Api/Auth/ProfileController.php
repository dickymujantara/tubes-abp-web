<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Profile;
use Auth;

class ProfileController extends Controller
{
    protected $status = 200;

    public function updateProfile(Request $request)
    {
        try {
            $profile = Profile::where(['id_user' => Auth::user()->id])->update([
                "phone_number" => $request->phoneNumber,
                "address" => $request->address,
            ]);

            $success['code'] = $this->status;
            $success['message'] = "Success";
            $success['data'] = $profile;

            return response()->json($success, 200);
        } catch (\Throwable $th) {
            return response()->json(['code' => 500,'error'=>$th], 500); 
        }
    }

    public function getProfile()
    {
        try {
            $profile = Profile::select()->where(['id_user' => Auth::user()->id])->first();

            $success['code'] = $this->status;
            $success['message'] = "Success";
            $success['data'] = $profile;

        } catch (\Throwable $th) {
            return response()->json(['code' => 500,'error'=>$th], 500); 
        }
    }

}
