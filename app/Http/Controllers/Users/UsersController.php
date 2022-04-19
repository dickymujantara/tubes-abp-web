<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UsersController extends Controller
{
    public function index()
    {
        return view("users-management.users");
    }

    public function getList(Request $request)
    {
        try {
            $data = User::select()->where(["role"=>'GENERAL'])->get();

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

    public function update(Request $request)
    {
        try {
            
            $update = User::where(["id" => $request->id])->update(["has_verified_email" => $request->status]);

            return response()->json($update, 200);

        } catch (\Throwable $th) {
            return response()->json($th);
        }
    }

}
