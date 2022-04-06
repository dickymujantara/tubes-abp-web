<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

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
}
