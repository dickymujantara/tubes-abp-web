<?php

namespace App\Http\Controllers\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BankAccount;

class BankAccountController extends Controller
{
    public function index()
    {
        return view('reference.bank-account.index');
    }

    public function listBankAccounts(Request $request)
    {
        try {
            $data = BankAccount::select()->orderBy('id', 'desc')->get();

            return response()->json([
                "data" => $data,
                "recordsTotal" => count($data),
                "recordsFiltered" => count($data)
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function detailBankAccount(Request $request)
    {
        try {
            $data = BankAccount::select()->where('id', $request->id)->first();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function storeBankAccount(Request $request)
    {
        try {
            $isUpdate = $request->filled('id');
            $store = null;

            if ($isUpdate) {
                $store = BankAccount::where('id', $request->id)->update([
                    'bank_name' => $request->bank_name,
                    'bank_number' => $request->bank_number,
                    'bank_user_name' => $request->bank_user_name,
                ]);
                $request->session()->flash('success', 'Update Bank Account Successfully!');

            }else{
                $store = BankAccount::create($request->all());
                $request->session()->flash('success', 'Create Bank Account Successfully!');
            }


        } catch (\Exception $e) {
            $request->session()->flash('error', 'Error : ' . $e->getMessage());
        }
        return redirect()->back();
    }

    public function changeStatusBankAccount(Request $request)
    {
        try {
            $store = BankAccount::where('id', $request->id)->update([
                'is_active' => $request->is_active,
            ]);

            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }
}
