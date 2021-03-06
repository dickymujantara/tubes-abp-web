<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminController extends Controller
{
    public function index()
    {
        return view("users-management.admin");
    }

    public function getList(Request $request)
    {
        try {
            $data = User::select()->where(["role"=>'ADMIN'])->get();

            return response()->json([
                "data" => $data,
                "recordsTotal" => count($data),
                "recordsFiltered" => count($data)
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

    public function getDetail(Request $request)
    {
        try {
            $data = User::select()->where(["id"=>$request->id])->first();

            return response()->json([
                "data" => $data
            ]);
        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }
}
