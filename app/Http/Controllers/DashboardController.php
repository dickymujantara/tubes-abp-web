<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rfp;
use Carbon\Carbon;
use Auth;
use DB;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard.index');
    }
}
