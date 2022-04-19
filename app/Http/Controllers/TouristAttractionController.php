<?php

namespace App\Http\Controllers;

use App\Models\OpenClose;
use App\Models\TouristAttraction;
use App\Services\UploadFile;
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
            'image' => 'required|mimes:png,jpg,jpeg|max:2048',
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
        $touristAttraction->image = UploadFile::image($request->file('image'));
        $touristAttraction->address = $request->address;
        $touristAttraction->phone = $request->phone;
        $touristAttraction->email_contact = $request->email_contact;
        $touristAttraction->website_information = $request->website;
        $touristAttraction->ticket_price = $request->ticket;
        $touristAttraction->save();

        $openCloseCount = count($request->day);
        $day = $request->day;
        $open = $request->open;
        $close = $request->close;

        for($i = 0; $i < $openCloseCount; $i++) {
            if ($day[$i] == null|| $open[$i] == null || $close[$i] == null) {
                continue;
            }

            $openClose = new OpenClose;
            $openClose->id_tourist_attraction = $touristAttraction->id;
            $openClose->day = $day[$i];
            $openClose->open = $open[$i];
            $openClose->close = $close[$i];
            $openClose->save();
        }

        return redirect()->route('touristatraction');
    }

    public function edit($id) {
        $touristAttraction = TouristAttraction::with('openclose')->where('id', $id)->first();

        return view('tourist_attraction.update', [
            'tourist_attraction' => $touristAttraction
        ]);
    }

    public function update(Request $request, $id) {
        $touristAttraction = TouristAttraction::where('id', $id)->first();
        OpenClose::where('id_tourist_attraction', $id)->truncate();

        if ($request->has('name')) {
            $touristAttraction->name = $request->name;
        }

        if ($request->has('image')) {
            $file = public_path() . $touristAttraction->image;

            if (file_exists($file)) {
                @unlink($file);
            }
            
            $touristAttraction->image = UploadFile::image($request->file('image'));
        }

        if ($request->has('address')) {
            $touristAttraction->address = $request->address;
        }

        if ($request->has('phone')) {
            $touristAttraction->phone = $request->phone;
        }

        if ($request->has('email_contact')) {
            $touristAttraction->email_contact = $request->email_contact;
        }

        if ($request->has('website')) {
            $touristAttraction->website_information = $request->website;
        }

        if ($request->has('ticket_price')) {
            $touristAttraction->ticket_price = $request->ticket;
        }

        $touristAttraction->save();

        $openCloseCount = count($request->day);
        $day = $request->day;
        $open = $request->open;
        $close = $request->close;

        for($i = 0; $i < $openCloseCount; $i++) {
            if ($day[$i] == null|| $open[$i] == null || $close[$i] == null) {
                continue;
            }

            $openClose = new OpenClose;
            $openClose->id_tourist_attraction = $id;
            $openClose->day = $day[$i];
            $openClose->open = $open[$i];
            $openClose->close = $close[$i];
            $openClose->save();
        }

        return redirect()->route('touristatraction');
    }

    public function deleteTouristAttraction($id) {
        $touristAttraction = TouristAttraction::where('id', $id)->first();
        $file = public_path() . $touristAttraction->image;

        if (file_exists($file)) {
            @unlink($file);
        }

        $touristAttraction->delete();

        return redirect()->route('touristatraction');
    }
}
