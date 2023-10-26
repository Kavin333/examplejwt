<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Models\Member;
use App\Models\Department;
use Validator;

class UserController extends Controller
{
    public function create_users(Request $request){
        try{
            $validate_department = Department::pluck('id')->toArray();
              $validator = Validator::make($request->all(),[
                'name'=>'required|string',
                'birth_date'=>'required|date',
                'age'=>'required|numeric',
                'profile_picture'=>'image|required|mimes:jpeg,jpg|max:2048',
                'gender'=>'required|in:male,female',
                'gmail'=>'required|email:rfc,dns|unique:users',
                'password'=>'required|string|min:4',
                'mobile'=>'required|regex:/^[6-9][0-9]*$/|min:10|max:10',
                'role'=>'required|in:student,staff',
                'position' => $request->input('role') == 'staff' ? 'required' : 'nullable',
                'department'=>['required',Rule::in($validate_department)],
            ]);
              if($validator->fails()){
                return $this->failure($validator->errors());
              }
              $user = new Member;
              $user->name = $request->input('name');
              $user->birth_date = $request->input('birth_date');
              $user->age = $request->input('age');
              $user->gender = $request->input('gender');
              $user->gmail = $request->input('gmail');
              $user->password = bcrypt($request->input('password'));
              $user->mobile = $request->input('mobile');
              $user->role = $request->input('role');
              if ($request->input('role') == 'staff') {
                $user->position = $request->input('position');
              }
              if($request->input('role')=='student'){
                $user->department = $request->input('department');
              }
              if($request->hasFile('profile_picture')){
                $image = $request->file('profile_picture');
                $filename = time().'_'.$image->getClientOriginalName();
                $image->storeAs('public/profile_pictures',$filename);
                $user->profile_picture = $filename;
              }
              $user->save();
              if($user->isStudent()){
                return $this->success('Student registered successfully');
              }
              else{
                return $this->success('Staff registered successfully');
              }

        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }
    }

    public function update_users(Request $request,$id){
        try{
             $validator = Validator::make($request->all(),[
                'name'=>'required|string',
                'birth_date'=>'required|date',
                'age'=>'required|numeric',
                'profile_picture'=>'image|required|mimes:jpeg,jpg|max:2048',
                'gender'=>'required|in:male,female',
                'gmail'=>'required|email',
                'password'=>'required|string|min:4',
                'mobile'=>'required|numeric',
                'role'=>'required|in:student,staff',
                'position'=>'required_if:role,staff'
              ]);
              if($validator->fails()){
                return $this->failure($validator);
              }
              $user = Member::find($id);
              if(!$user){
                return $this->failure('User not found');
              }
              $user->name = $request->input('name');
              $user->birth_date = $request->input('birth_date');
              $user->age = $request->input('age');
              $user->profile_picture = $request->input('profile_picture');
              $user->gender = $request->input('gender');
              $user->gmail = $request->input('gmail');
              $user->password = $request->input('password');
              $user->mobile = $request->input('mobile');
              if ($request->hasFile('profile_picture')) {
                $image = $request->file('profile_picture');
                $filename = time() . '_' . $image->getClientOriginalName();
                $image->storeAs('public/profile_pictures', $filename);
                $user->profile_picture = $filename;
            }
              $user->save();
              return $this->success($user);
        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }
    }

    public function delete_users($id) {
        try {
            $user = Member::find($id);

            if (!$user) {
                return $this->failure("User not found");
            }
            if ($user->profile_picture) {
                $profilePicturePath = storage_path('app/public/profile_pictures/') . $user->profile_picture;
                if (file_exists($profilePicturePath)) {
                    unlink($profilePicturePath);
                }
            }
            $user->delete();
            return $this->success("User with ID $id has been deleted");
        } catch (\Exception $e) {
            return $this->failure($e->getMessage());
        }
    }

    public function list_users(Request $request){
        try{
             $user = Member::all();
             return $this->success($user);
        }
        catch(\Exception $e){
            return $this->failure($e->getMessage());
        }
    }
}
