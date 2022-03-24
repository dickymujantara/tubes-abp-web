<?php

namespace App\Http\Controllers\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Media;
use Auth;

class MediaController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        if ($role == "SUPERADMIN" ) {
            return view('reference.media.index');
        }else{
            return redirect(route('dashboard'));
        }
    }

    public function listMedias(Request $request)
    {
        try {
            $data = Media::select()->orderBy('id', 'desc')->get();

            return response()->json([
                "data" => $data,
                "recordsTotal" => count($data),
                "recordsFiltered" => count($data)
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function detailMedia(Request $request)
    {
        try {
            $data = Media::select()->where('id', $request->id)->first();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

}
