<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class listController extends Controller
{
    public function index(){
        $lists = DB::table('visit_list')
            ->get();
        return view('list.index', ['lists'=>$lists]);
    
    }
    
}
