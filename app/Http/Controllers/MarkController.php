<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Mark;
use App\Models\User;
use App\Models\Subject;
use Validator;

class MarkController extends Controller
{
       public function enter_marks(Request $request){
        try{
             $validator = Validator::make($request->all(),[
                'student_id'=>'required|numeric|exists:users,id',
                'subject_id'=>'required|numeric|exists:subjects,id',
                'mark'=>'required|numeric',
             ]);
             if($validator->fails()){
                return $this->failure($validator->errors());
             }

             $student = User::find($id,'department');
             $subject = Subject::find($id);
             $marks = new Mark();
             $marks->student_id = $request->input('student_id');
             $marks->subject_id = $request->input('subject_id');
             $marks->mark = $request->input('mark');
             $marks->save();
             return $this->success($marks);
        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }
       }

       public function update_marks(Request $request,$id){
        try{
            $validator = Validator::make($request->all(),[
                'student_id'=>'required|numeric',
                'subject_id'=>'required|numeric|exists:subjects,id',
                'mark'=>'required|numeric',
             ]);
             if($validator->fails()){
                return $this->failure($validator->errors());
             }
             $marks = Mark::find($id);
             $marks->student_id = $request->input('student_id');
             $marks->subject_id = $request->input('subject_id');
             $marks->mark = $request->input('mark');
             $marks->save();
             return $this->success($marks);
        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }
       }
       public function delete_marks(Request $request){
        try{

        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }
       }


       public function studentDetails($id) {
        try {
            // Find the student by ID along with their associated department
            $student = Student::with('department')->find($id);

            if (!$student) {
                return $this->failure('Student not found');
            }

            // Retrieve the subjects and marks associated with the student
            $subjectsAndMarks = Subject::where('student_id', $student->id)
                ->join('marks', 'subjects.id', '=', 'marks.subject_id')
                ->get(['subjects.subject_name', 'marks.mark']);

            $studentDetails = [
                'student_name' => $student->student_name,
                'department' => $student->department, // Include department details
                'subjects_and_marks' => $subjectsAndMarks,
            ];

            return $this->success($studentDetails);
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }






}
