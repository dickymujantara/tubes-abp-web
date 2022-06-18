<?php

namespace App\Http\Controllers\Api\TouristAttraction;

use App\Http\Controllers\Controller;
use App\Models\TouristAttraction;
use Illuminate\Http\Request;

class TouristAttractionController extends Controller
{
    public function touristAttractionList() 
    {
        $touristAttractionList = TouristAttraction::with('openclose')->get();
        
        return response()->json(
            $touristAttractionList
        , 200);
    }
}