<?php

namespace App\Http\Controllers;

use App\Models\TouristAttraction;
use Illuminate\Http\Request;

class TouristAttractionController extends Controller
{
    public function index() {
        $touristAttraction = TouristAttraction::all();

        return view('tourist_attraction.index', [
            'touristAttractions' => $touristAttraction
        ]);
    }

    public function add() {
        return view('tourist_attraction.create');
    }

    public function create(Request $request) {
        
        $request->validate([
            'name' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email_contact' => 'required|sometimes',
            'website' => 'required|sometimes',
            'ticket' => 'required|sometimes'
        ],
        [
            'name.required' => 'Nama Tempat Harus diisi',
            'address.required' => 'Alamat Harus diisi',
            'phone.required' => 'No Telp Harus diisi'
        ]);

        $touristAttraction = new TouristAttraction();
        $touristAttraction->name = $request->name;
        $touristAttraction->address = $request->address;
        $touristAttraction->phone = $request->phone;
        $touristAttraction->email_contact = $request->email_contact;
        $touristAttraction->website_information = $request->website;
        $touristAttraction->ticket_price = $request->ticket;
        $touristAttraction->save();

        return redirect()->route('touristatraction');
    }
}
