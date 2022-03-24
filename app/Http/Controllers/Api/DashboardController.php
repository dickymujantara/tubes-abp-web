<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rfp;
use Carbon\Carbon;
use Auth;
use DB;

class DashboardController extends Controller
{
    protected $code = 200;

    public function chartRfp(Request $request)
    {
        $data = Rfp::select([
            DB::raw('DATE(created_at) AS date'),
            DB::raw('COUNT(id) AS count'),
        ])
        ->where(['id_user' => Auth::user()->id])
        ->whereBetween('created_at', [$request->startdate, $request->enddate])
        ->groupBy('date')
        ->orderBy('date', 'ASC')
        ->get();

        $response['code'] = $this->code;
        $response['message'] = "Success";
        $response['data'] = $data;

        return response()->json($response);
    }

    public function cardRfp(Request $request)
    {
        $waiting = $this->getRfp(1,$request->periode);
        $approveMan = $this->getRfp(2,$request->periode);
        $approveAdm = $this->getRfp(3,$request->periode);
        $transfer = $this->getRfp(4,$request->periode);
        $reject = $this->getRfp(5,$request->periode);

        $data = [
            "periode" => $request->periode,
            "rfp" => [
                "waiting" => $waiting,
                "approveManager" => $approveMan,
                "approveAdmin" => $approveAdm,
                "transfer" => $transfer,
                "reject" => $reject
            ]
        ];

        $response['code'] = $this->code;
        $response['message'] = "Success";
        $response['data'] = $data;

        return response()->json($response);
    }

    private function getRfp($status,$periode)
    {
        $data = Rfp::select()->where(["status" => $status])
        ->where(['id_user' => Auth::user()->id])
        ->where('created_at','like','%'.$periode.'%')
        ->get()->count();

        return $data;
    }

}
