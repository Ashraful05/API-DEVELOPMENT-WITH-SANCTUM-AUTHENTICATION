<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function createProject(Request $request)
    {
        //validate data...
        $this->validate($request,[
            'name'=>'required',
            'description'=>'required',
            'duration'=>'required'
        ]);

        //student id  +  create data...

        $student_id = auth()->user()->id;
        $project = new Project();
        $project->student_id = $student_id;
        $project->name = $request->name;
        $project->description= $request->description;
        $project->duration= $request->duration;
        $project->save();

        //send response...
        return response()->json([
           'status' => 1,
           'message' => 'Project Info Saved Successfully!!!'
        ]);
    }
    public function listProject()
    {
        $student_id = auth()->user()->id;
        $projects = Project::where('student_id',$student_id)->get();
//        $projects = Project::all();
        return response()->json([
           'status' => 1,
           'message' => "projects",
           'data' => $projects
        ]);
    }
    public function getSingleProject($id)
    {
        $student_id = auth()->user()->id;
        if(Project::where([
            'id'=>$id,
            'student_id'=>$student_id
        ])->exists()){
            $details = Project::where([
                'id'=>$id,
                'student_id'=>$student_id,
            ])->first();
            return response()->json([
               'status' => 1,
               'message' => 'Project Details',
                'data' => $details
            ]);
        }else{
            return response()->json([
               'status'=>0,
               'message' => 'Project not found!!!'
            ]);
        }
    }
    public function deleteProject($id)
    {
        $student_id = auth()->user()->id;
        if(Project::where([
            'id'=>$id,
            'student_id'=>$student_id
        ])->exists()){
            $project = Project::where([
                'id'=>$id,
                'student_id'=>$student_id
            ])->first();

            $project->delete();

            return response()->json([
               'status'=> 1,
               'message' => 'Deleted successfully!!!'
            ]);
        }
        else{
            return response()->json([
               'status'=>0,
               'message'=>'Project not found'
            ]);
        }

    }
}
