<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Student;
use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    public function studentRegister(Request $request)
    {
        //validate data
        $this->validate($request,[
           'name'=>'required',
           'email'=>'required|email|unique:students',
            'password'=>'required|confirmed'
        ]);
        //store data
        $register = new Student();
        $register->name = $request->name;
        $register->email= $request->email;
        $register->password = Hash::make($request->password);
        $register->phone_no = isset($request->phone_no)?$request->phone_no: '';

        $register->save();

        //response
        return response()->json([
           'status'=>1,
           'message'=>'Information saved successfully!!!'
        ]);
    }
    public function studentLogin(Request $request)
    {
        //validation
        $this->validate($request,[
           'email'=>'required|email',
           'password'=>'required'
        ]);
        //check student
        $student = Student::where('email','=',$request->email)->first();
        if(isset($student->id)){
            if(Hash::check($request->password, $student->password)){
                //create token
                $token = $student->createToken("auth_token")->plainTextToken;
                //send a response
                return response()->json([
                   'status'=>1,
                   'message'=>'Student LoggedIn Successfully!!!',
                    'access_token'=>$token
                ]);
            }else{
                return response()->json([
                   'status'=>0,
                   'message'=>'Password did not match!!!'
                ],404);
            }

        }else{
            return response()->json([
                'status'=>0,
                'message'=>'Student Not Found!!'
            ],404);
        }


    }
    public function studentProfile()
    {
        return response()->json([
           'status'=>1,
            'message'=>'Student Profile Information',
            'data'=>auth()->user()
        ]);
    }
    public function studentLogout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
           'status'=>1,
           'message'=>'Student Successfully LoggedOut!!'
        ]);
    }
}
