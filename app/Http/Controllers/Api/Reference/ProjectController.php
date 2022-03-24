<?php

namespace App\Http\Controllers\Api\Reference;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Project;

class ProjectController extends Controller
{
    protected $size = 10;
    protected $code = 200;

    public function listProjectsPaginate(Request $request)
    {
        try {
            $data = Project::where('project_name','like','%'.$request->project_name.'%')
                    ->where('project_number','like','%'.$request->project_number.'%')->paginate($request->size);

            $response['code'] = $this->code;
            $response['message'] = "Success";
            $response['data'] = $data;

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function listProjects(Request $request)
    {
        try {
            $data = Project::select()->where('project_name','like','%'.$request->project_name.'%')
                    ->where('project_number','like','%'.$request->project_number.'%')->get();

            $response['code'] = $this->code;
            $response['message'] = "Success";
            $response['data'] = $data;

            return response()->json($response, 200);
        } catch (\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

}
