<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Auth;

class InboxController extends Controller
{
    protected $size = 10;
    protected $code = 200;
    protected $response = [];

    public function listInbox(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $data = Notification::select('notifications.*','profiles.fullname', 'media.path_photo')
            ->where(['id_user_to' => $userId])
            ->join('users', 'users.id' , '=' , "notifications.id_user_from")
            ->join('profiles', 'profiles.id_user' , '=' , "users.id")
            ->join('media', 'media.id' , '=' , "profiles.id_media")
            ->orderBy("notifications.id",'desc')->paginate($request->size);

            $this->response['code'] = $this->code;
            $this->response['message'] = "Success";
            $this->response['data'] = $data;

        } catch (\Exception $e) {
            $this->response['code'] = 500;
            $this->response['message'] = $e->getMessage();
            $this->response['data'] = null;
        }

        return response()->json($this->response);
    }

    public function getInbox(Request $request)
    {
        try {
            $data = Notification::select('notifications.*','profiles.fullname', 'media.path_photo')
            ->join('users', 'users.id' , '=' , "notifications.id_user_from")
            ->join('profiles', 'profiles.id_user' , '=' , "users.id")
            ->join('media', 'media.id' , '=' , "profiles.id_media")
            ->where('notifications.id',$request->id)->first();

            if ($data->is_read == 0) {
                Notification::where('id',$request->id)->update(['is_read' => 1]);
            }

            $this->response['code'] = $this->code;
            $this->response['message'] = "Success";
            $this->response['data'] = $data;

        } catch (\Exception $e) {
            $this->response['code'] = 500;
            $this->response['message'] = $e->getMessage();
            $this->response['data'] = null;
        }

        return response()->json($this->response);
    }

    public function deleteInbox(Request $request)
    {
        try {
            $data = Notification::where('id',$request->id)->delete();
            
            $this->response['code'] = $this->code;
            $this->response['message'] = "Success";
            $this->response['data'] = $data;

        } catch (\Exception $e) {
            $this->response['code'] = 500;
            $this->response['message'] = $e->getMessage();
            $this->response['data'] = null;
        }

        return response()->json($this->response);
    }

}
