<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\VisitList;

class listController extends Controller
{
    protected $status = 200;

    public function index(){
        $lists = DB::table('visit_list')
        ->join('users', 'visit_list.id_user', '=', 'users.id')
        ->join('tourist_attraction', 'visit_list.id_tourist_attraction', '=', 'tourist_attraction.id')
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

    public function create(Request $request){
        $visit = new VisitList();

        $request -> validate([
            'id_user'=>'required',
            'id_tourist_attraction'=>'required',
            'visit_date'=>'required',
        ]);

        $visit->id_user = $request->input('id_user');
        $visit->id_tourist_attraction = $request->input('id_tourist_attraction');
        $visit->visit_date = $request->input('visit_date');

        $visit->save();
        return response()->json($visit);
    }

    public function read(){
        try {
            $visit = VisitList::select('visit_list.*',"users.name", "tourist_attraction.*")->join('users', 'visit_list.id_user', '=', 'users.id')
            ->join('tourist_attraction', 'visit_list.id_tourist_attraction', '=', 'tourist_attraction.id')->orderBy('visit_list.id','ASC')->get();

            $success['code'] = $this->status;
            $success['message'] = "Success";
            $success['data'] = $visit;

            return response()->json($success);

        } catch (\Exception $e) {
            return response()->json(['code' => 500,'error'=>$e->getMessage()], 500); 
        }
       
    }

    public function edit($id){
        $visit = VisitList::findOrFail($id);
        return response()->json($visit);
    }

    public function update(Request $request,$id){
        $visit = VisitList::findOrFail($id);

        $visit->id_user = $request->input('id_user');
        $visit->id_tourist_attraction = $request->input('id_tourist_attraction');
        $visit->visit_date = $request->input('visit_date');
   
        $visit->save();
        return response()->json($visit);
    }

    public function delete($id){
        $visit = VisitList::findOrFail($id);

        $visit->delete();
        return response()->json($visit);
    }
}
