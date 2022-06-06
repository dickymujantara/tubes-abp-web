<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Story;

class StoryController extends Controller
{
    protected $status = 200;

    public function readStories(Request $request)
    {
        try {
            $data = Story::join('users', 'story.id_user', '=', 'users.id')
                ->orderBy('story.id','ASC')->get();
            $success['code'] = $this->status;
            $success['message'] = "Success";
            $success['data'] = $data;

            return response()->json($data, 200);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }
}
