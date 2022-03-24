<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Profile;
use App\Models\User;
use App\Models\Media;

class ProfileController extends Controller
{
    protected $status = 200;

    public function getProfile()
    {
        try {
            $profile = Profile::select('profiles.*', 'users.username', 'users.email', 'users.role', 'media.path_photo', 'media.label', 'media.description')
                    ->join('media','profiles.id_media', '=', 'media.id')
                    ->join('users','profiles.id_user', '=', 'users.id')
                    ->where('id_user',Auth::user()->id)->first();
            
            $data['code'] = $this->status;
            $data['message'] = "Success";
            $data['data'] = $profile;

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
    
    public function updateProfile(Request $request)
    {
        try {
            $data = [];

            $profile = Profile::where('id_user',Auth::user()->id)->update([
                'fullname' => $request->fullname,
                'nik' => $request->nik,
                'phone_number' => $request->phone_number
            ]);

            $users = User::where('id',Auth::user()->id)->update([
                "username" => $request->username,
                "email" => $request->email
            ]);

            if ($profile && $users) {
                $profile = Profile::select('profiles.*', 'users.username', 'users.email', 'users.role', 'media.path_photo', 'media.label', 'media.description')
                    ->join('media','profiles.id_media', '=', 'media.id')
                    ->join('users','profiles.id_user', '=', 'users.id')
                    ->where('id_user',Auth::user()->id)->first();
            
                $data['code'] = $this->status;
                $data['message'] = "Success";
                $data['data'] = $profile;

            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function updatePhoto(Request $request)
    {
        try {
            $data = [];

            $media = Media::create(['path_photo' => $request->photo]);

            if ($media) {
                $profile = Profile::where('id_user',Auth::user()->id)->update([
                    'id_media' => $media->id
                ]);
    
                if ($profile) {
                    $profile = Profile::select('profiles.*', 'media.path_photo', 'media.label', 'media.description')
                        ->join('media','profiles.id_media', '=', 'media.id')
                        ->where('id_user',Auth::user()->id)->first();
                
                    $data['code'] = $this->status;
                    $data['message'] = "Success";
                    $data['data'] = $profile;
    
                }
            }

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function changePassword(Request $request)
    {
        $data = [];
        try {
           
            if ($request->password == $request->conPassword) {
                
                $change = User::where('id', Auth::user()->id)->update([
                    "password" => Hash::make($request->password)
                ]);

                if ($change) {
                    $data['code'] = $this->status;
                    $data['message'] = "Success";
                    $data['data'] = "Password Updated!";

                    return response()->json($data, 200);
                }

            }else{
                $data['code'] = 500;
                $data['message'] = "Error";
                $data['data'] = "Password Not Match!";
                return response()->json($data, 500);
            }

        } catch (\Exception $e) {
            $data['code'] = 500;
            $data['message'] = "Error";
            $data['data'] = $e->getMessage();
            return response()->json($data, 500);
        }
    }

}
