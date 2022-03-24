<?php

namespace App\Http\Controllers\Api\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankAccount;

class BankAccountController extends Controller
{
    protected $size = 10;
    protected $code = 200;

    public function listBankPaginate(Request $request)
    {
        try {
            $data = BankAccount::where('bank_number','like','%'.$request->bank_number.'%')
                    ->where('bank_name','like','%'.$request->bank_name.'%')
                    ->where('bank_user_name','like','%'.$request->bank_user_name.'%')->paginate($request->size);

            $response['code'] = $this->code;
            $response['message'] = "Success";
            $response['data'] = $data;


            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function listBank(Request $request)
    {
        try {
            $data = BankAccount::select()->where('bank_number','like','%'.$request->bank_number.'%')
            ->where('bank_name','like','%'.$request->bank_name.'%')
            ->where('bank_user_name','like','%'.$request->bank_user_name.'%')->get();

            $response['code'] = $this->code;
            $response['message'] = "Success";
            $response['data'] = $data;

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }
}
