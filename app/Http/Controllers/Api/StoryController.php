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
            $data = Story::select('users.username','users.name','story.*')
                ->join('users', 'story.id_user', '=', 'users.id')
                ->orderBy('story.id','ASC')->get();
            $success['code'] = $this->status;
            $success['message'] = "Success";
            $success['data'] = $data;

            return response()->json($success, 200);
        } catch (\Exception $e) {
            return response()->json($e, 500);
        }
    }

    public function create(Request $request){
        $story = new Story();

        $request -> validate([
            'id_user'=>'required',
            'title'=>'required',
            'content'=>'required',
            'image'=>'required|max:2056||mimes:jpg,png,jpeg',
            'like_count'=>'required',
        ]);

        $filename = "";
        if($request->hasfile('image')){
            $filename = $request->file('image')->store('story', 'public');
        }else{
            $filename = NULL;
        }

        $story->id_user = $request->input('id_user');
        $story->title = $request->input('title');
        $story->content = $request->input('content');
        $story->image = $filename;
        $story->like_count = $request->input('like_count');

        $story->save();

        $success['code'] = $this->status;
        $success['message'] = "Success";
        $success['data'] = $story;
        return response()->json($success);
    }

    public function edit($id){
        $story = Story::findOrFail($id);
        $success['code'] = $this->status;
        $success['message'] = "Success";
        $success['data'] = $story;

        return response()->json($success);
    }

    public function update(Request $request,$id){
        $story = Story::findOrFail($id);

        $destination = public_path("storage\\".$story->image);
        $filename = "";
        if($request->hasfile('image')){
            if(File::exists($destination)){
                File::delete($destination);
            }

            $filename = $request->file('image')->store('story', 'public');
        }else{
            $filename = $request->image;
        }

        $story->id_user = $request->input('id_user');
        $story->title = $request->input('title');
        $story->content = $request->input('content');
        $story->image = $filename;
        $story->like_count = $request->input('like_count');

        $story->save();

        $success['code'] = $this->status;
        $success['message'] = "Success";
        $success['data'] = $story;
        return response()->json($success);
    }

    public function deletestory($id){
        $story = Story::findOrFail($id);

        $destination = public_path("storage\\".$story->image);
        if(File::exists($destination)){
            File::delete($destination);
        }

        $story->delete();
        $success['code'] = $this->status;
        $success['message'] = "Success";
        $success['data'] = $story;

        return response()->json($success);
    }
}
