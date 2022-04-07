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

    public function touristatraction(){
        $tas = DB::table('tourist_attraction')
            ->get();
        return view('list.touristatraction', ['tas'=>$tas]);

    }
    
    public function taupdate(Request $request){
        $id = $request->id;
        $tas = DB::table('tourist_attraction')
        ->where('id','=',$id)
        ->get();
        return view('list.taupdate', ['tas'=>$tas]);

    }
    public function taupdateproses(Request $request){
        $id = $request->id;
        $name = $request->name;
        $address = $request->address;
        $phone = $request->phone;
        $email = $request->email_contact;
        $web = $request->website;
        $ticket = $request->ticket;

        DB::table('tourist_attraction')
       ->where('id','=',$id)
       ->update([
           'name'=>$name,
           'address'=>$address,
           'phone'=>$phone,
           'email_contact'=>$email,
           'website_information'=>$web,
           'ticket_price'=>$ticket,
       ]);
        return redirect('touristatraction');
    }
}
