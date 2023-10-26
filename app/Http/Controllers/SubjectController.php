<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Subject;
use Validator;

class SubjectController extends Controller
{
    public function create_subject(Request $request){
        try{
               $validator = Validator::make($request->all(),[
                'department_id'=>'required|numeric|exists:departments,id',
                'subject_name'=>'required|string|unique:subjects',
               ]);
               if($validator->fails()){
                return $this->failure($validator->errors());
               }
               $subjects = new Subject;
               $subjects->department_id = $request->input('department_id');
               $subjects->subject_name = $request->input('subject_name');
               $subjects->save();
               return $this->success($subjects);
        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }
    }
    public function update_subject(Request $request,$id){
        try{
               $validator = Validator::make($request->all(),[
                'department_id'=>'required|numeric|exists:departments,id',
                'subject_name'=>'required|string|unique:subjects',
               ]);
               if($validator->fails()){
                return $this->failure($validator->errors());
               }
               $subjects = Subject::find($id);
               $subjects->department_id = $request->input('department_id');
               $subjects->subject_name = $request->input('subject_name');
               $subjects->save();
               return $this->success($subjects);
        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }

    }
    public function delete_subject(Request $request,$id){
        try{

               $subjects = Subject::find($id);
               $subjects->delete();
               return $this->success('Deleted successfully');
        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }

    }
    public function list_subject(){
        try{

               $subjects = Subject::all();
               return $this->success($subjects);
        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }

    }
}
