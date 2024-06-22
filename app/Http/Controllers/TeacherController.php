<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Teacher;
use App\Models\Department;
use Brian2694\Toastr\Facades\Toastr;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class TeacherController extends Controller
{

    public function main()
    {
        // Retrieve the authenticated user's ID (assuming it's a teacher's ID)
        $teacherId = Auth::id();

        // Now $teacherId holds the ID of the authenticated teacher

        // You can use $teacherId in further logic, such as querying data or passing it to a view
        $teacher = Teacher::find($teacherId);

        return view('teacher.profile', compact('teacher'));
    }
    
    public function teacherAdd()
    {
        $departments = Department::all(); // Fetch all departments
        return view('teacher.add-teacher', compact('departments'));
    }
    

    /** teacher list */
    public function teacherList()
    {
        /** AMIK DRI USERS TABLE */
        //$teacherList = DB::table('users')
            //->join('teachers','teachers.teacher_id','users.user_id')
            //->select('users.user_id','users.name','users.avatar','teachers.id','teachers.gender','teachers.mobile','teachers.address')
            //->get();
            $teacherList = Teacher::all();
           return view('teacher.list-teachers',compact('teacherList'));
    }


    /** teacher Grid */
    public function teacherGrid()
    {
        $teacherGrid = Teacher::all();
        return view('teacher.teachers-grid',compact('teacherGrid'));
    }

    /** save record */
    public function saveRecord(Request $request)
{
    /** DETAILS DARI FORM ADD TUTOR */
    $request->validate([
        'full_name'       => 'required|string',
        'gender'          => 'required|string',
        'date_of_birth'   => 'required|string',
        'mobile'          => 'required|string',
        //'joining_date'    => 'required|string',
       
        'username'        => 'required|string',
        'email'           => 'required|string',
        'password'        => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required',
        'address'         => 'required|string',
        'city'            => 'required|string',
        'state'           => 'required|string',
        'zip_code'        => 'required|string',
        'country'         => 'required|string',
        'status'         => 'required|string',
        'dept_id' => 'exists:department,d_id', 
    ]);

    try {

        $dt        = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();

        // Check if the teacher with the provided admission ID already exists
        if (Teacher::where('teacher_id', $request->teacher_id)->exists()) {
            Toastr::error('Teacher with the provided admission ID already exists :(', 'Error');
            return redirect()->back();
        }

        // Hash the password before saving it to the database
        $password = Hash::make($request->password);

        // Save record in User table
        $user = User::create([
            'name'      => $request->full_name,
            'email'     => $request->email,
            'join_date' => $todayDate,
            'status'=> $request->status,
            'role_name' => 'Teachers',
            'password'  => $password,
            'address'     => $request->address,
            'city'     => $request->city,
            'state'     => $request->state,
            'zip_code'     => $request->zip_code,
            'country'     => $request->country,
            'phone_number'     => $request->mobile,

        ]);

        /** SAVE RECORD DALAM USERS TABLE */

        $saveRecord = new Teacher;

        $saveRecord->teacher_id    = $request->teacher_id;
        $saveRecord->full_name     = $request->full_name;
        $saveRecord->gender        = $request->gender;
        $saveRecord->date_of_birth = $request->date_of_birth;
        $saveRecord->mobile        = $request->mobile;
        $saveRecord->joining_date  = $todayDate;
      
        $saveRecord->username      = $request->username;
        $saveRecord->email        = $request->email;
        $saveRecord->password        = $password;
        $saveRecord->address       = $request->address;
        $saveRecord->city          = $request->city;
        $saveRecord->state         = $request->state;
        $saveRecord->zip_code      = $request->zip_code;
        $saveRecord->country       = $request->country;
        $saveRecord->status     = $request->status;
        $saveRecord->department()->associate(Department::find($request->dept_id));
        $saveRecord->save();


        // Associate the teacher with a department
       // $department = Department::find($request->d_id);
       /// $saveRecord->department()->associate($department);
       // $saveRecord->save();

        Toastr::success('Has been add successfully :)','Success');
        return redirect()->route('teacher/list/page');
    } catch(\Exception $e) {
        \Log::info($e);
        DB::rollback();
        Toastr::error('fail, Add new record  :)','Error');
        return redirect()->back();
    }
}
    
    public function editRecord($id)
{
    $editRecord = Teacher::findOrFail($id);
    $departments = Department::all();
    $passwordHash = $editRecord->password; // Retrieve the password hash from the database
    return view('teacher.edit-teacher', compact('editRecord', 'departments','passwordHash'));
}
    

    /**UPDATE DATA */
    public function updateRecordTeacher(Request $request)
    {
    $request->validate([
        'id' => 'required|exists:teachers,id',
        'teacher_id' => 'required|string',
        'full_name' => 'required|string',
        'gender' => 'required|string',
        'date_of_birth' => 'required|string',
        'mobile' => 'required|string',
        'username' => 'required|string|unique:teachers,username,'.$request->id,
        'email' => 'required|email|unique:teachers,email,'.$request->id,
        'password' => 'nullable|min:8|confirmed',
        'address' => 'required|string',
        'city' => 'required|string',
        'state' => 'required|string',
        'zip_code' => 'required|string',
        'country' => 'required|string',
        'status' => 'required|string',
        'dept_id' => 'required|exists:department,d_id', // Corrected table name
    ]);

    DB::beginTransaction();

    try {
        // Check if the teacher with the given id exists
        $existingTeacher = Teacher::find($request->id);

        if (!$existingTeacher) {
            Toastr::error('Teacher not found :(', 'Error');
            return redirect()->back();
        }

        // Update teacher fields
        $existingTeacher->teacher_id = $request->teacher_id;
        $existingTeacher->full_name = $request->full_name;
        $existingTeacher->gender = $request->gender;
        $existingTeacher->date_of_birth = $request->date_of_birth;
        $existingTeacher->mobile = $request->mobile;
        $existingTeacher->email = $request->email;
        $existingTeacher->username = $request->username;
        
        // Update password only if provided
        if (!empty($request->password)) {
            $existingTeacher->password = Hash::make($request->password);
        }

        $existingTeacher->address = $request->address;
        $existingTeacher->city = $request->city;
        $existingTeacher->state = $request->state;
        $existingTeacher->zip_code = $request->zip_code;
        $existingTeacher->country = $request->country;
        $existingTeacher->status = $request->status;
        $existingTeacher->dept_id = $request->dept_id;

        $existingTeacher->save();

        // Update the corresponding user record
        $user = User::where('email', $existingTeacher->email)->first();
        if ($user) {
            $user->name = $request->full_name;
            $user->email = $request->email;
            $user->status = $request->status;
            if (!empty($request->password)) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        }

        // Update the department association
        $existingTeacher->department()->associate(Department::find($request->dept_id));
        $existingTeacher->save(); // Save the updated association

        DB::commit();
        Toastr::success('Teacher record has been updated successfully :)', 'Success');
        return redirect()->route('teacher/list/page');
    } catch (\Exception $e) {
        \Log::error($e);
        DB::rollback();
        Toastr::error('Failed to update teacher record :(', 'Error');
        return redirect()->back();
    }
}





     /** teacher delete */
 public function teacherDelete($id)
 {
     DB::beginTransaction();
     try {
         // Find the teacher by ID
         $teacher = Teacher::find($id);

         // Find the user by email
         $user = User::where('email', $teacher->email)->first();

         if ($user) {
             $user->delete(); // Delete the user record
         }

         $teacher->delete(); // Delete the student record

         DB::commit();
         Toastr::success('Deleted record successfully :)','Success');
         return redirect()->route('teacher/list/page');
     } catch(\Exception $e) {
         DB::rollback();
         Toastr::error('Failed to delete record :(', 'Error');
         return redirect()->back();
     }
 }


 

   
  



    
}
