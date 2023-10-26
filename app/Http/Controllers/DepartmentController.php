<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\Subject;
use Validator;

class DepartmentController extends Controller
{
    public function create_department(Request $request){
        try{
             $validator = Validator::make($request->all(),[
                'department_name'=>'required|string|unique:departments',
             ]);
             if($validator->fails()){
                return $this->failure($validator->errors());
             }

             $departments = new Department();
             $departments->department_name = $request->input('department_name');
             $departments->save();

             return $this->success($departments);

        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }
    }
    public function update_department(Request $request,$id){
        try{
             $validator = Validator::make($request->all(),[
                'department_name'=>'required|string|unique:departments',
             ]);
             if($validator->fails()){
                return $this->failure($validator->errors());
             }

             $departments = Department::find($id);
             if(!$departments){
                return $this->failure('Department not found');
             }
             $departments->department_name = $request->input('department_name');
             $departments->save();

             return $this->success($departments);

        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }
    }

    public function delete_department(Request $request,$id){
        try{
             $departments = Department::find($id);
             if($departments){
                $departments->delete();
                return $this->success('Department removed');
              }
        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }
    }

    public function list_department(Request $request){
        try{
             $departments = Department::all();
             return $this->success($departments);
        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }
    }
    public function list_department_subjects($id){
        try{
            $department = Department::find($id);

            if (!$department) {
                return $this->failure('Department not found');
            }
            $subjects = Subject::where('department_id', $department->id)->get();
            return $this->success($subjects);
        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }
    }

}
