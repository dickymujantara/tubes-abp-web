<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Story;
use Illuminate\Support\Facades\File;

class StoryController extends Controller
{
    public function index(){
        $storys = DB::table('story')
            ->get();
        return view('story.index', ['storys'=>$storys]);
    }

    public function detail(Request $request){
        $id = $request->id;
        $storys = DB::table('story')
        ->where('id', '=', $id)
        ->get();

        return view('story.detail', ['storys'=>$storys]);
    }

    public function delete(Request $request){
        $id = $request->id;
        DB::table('story')
        ->where('id', '=', $id)
        ->delete();
        return redirect('story');
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
        return response()->json($story);
    }

    public function read(){
        $story = Story::orderBy('id','ASC')->get();
        return response()->json($story);
    }

    public function edit($id){
        $story = Story::findOrFail($id);
        return response()->json($story);
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
        return response()->json($story);
    }

    public function deletestory($id){
        $story = Story::findOrFail($id);

        $destination = public_path("storage\\".$story->image);
        if(File::exists($destination)){
            File::delete($destination);
        }

        $story->delete();
        return response()->json($story);
    }
}
