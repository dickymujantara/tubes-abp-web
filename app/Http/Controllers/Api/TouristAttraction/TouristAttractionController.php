<?php

namespace App\Http\Controllers\Api\TouristAttraction;

use App\Http\Controllers\Controller;
use App\Models\TouristAttraction;
use Illuminate\Http\Request;

class TouristAttractionController extends Controller
{
    protected $status = 200;

    public function touristAttractionList() 
    {
        $touristAttractionList = TouristAttraction::with('openclose')->get();
        $success['code'] = $this->status;
        $success['message'] = "Success";
        $success['data'] = $touristAttractionList;

        return response()->json($success, 200);
    }
}