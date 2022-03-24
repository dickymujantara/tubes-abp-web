<?php

namespace App\Http\Controllers\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;
use Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $role = Auth::user()->role;
        if ($role == "SUPERADMIN" ) {
            return view('reference.project.index');
        }else{
            return redirect(route('dashboard'));
        }
    }

    public function listProjects(Request $request)
    {
        try {
            $data = Project::select()->orderBy('id', 'desc')->get();

            return response()->json([
                "data" => $data,
                "recordsTotal" => count($data),
                "recordsFiltered" => count($data)
            ]);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function detailProject(Request $request)
    {
        try {
            $data = Project::select()->where('id', $request->id)->first();

            return response()->json($data);
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

    public function storeProject(Request $request)
    {
        try {
            $isUpdate = $request->filled('id');
            $store = null;

            if ($isUpdate) {
                $store = Project::where('id', $request->id)->update([
                    'project_name' => $request->project_name,
                    'project_number' => $request->project_number,
                ]);
                $request->session()->flash('success', 'Update Project Successfully!');

            }else{
                $store = Project::create($request->all());
                $request->session()->flash('success', 'Create Project Successfully!');
            }


        } catch (\Exception $e) {
            $request->session()->flash('error', 'Error : ' . $e->getMessage());
        }
        return redirect()->back();
    }

    public function changeStatusProject(Request $request)
    {
        try {
            $store = Project::where('id', $request->id)->update([
                'is_active' => $request->is_active,
            ]);

            return redirect()->back();
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

}
