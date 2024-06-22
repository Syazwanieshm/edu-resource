<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use App\Models\ClassRoom;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class StudentController extends Controller
{
    /** index page student list */
    public function student()
    {
        $studentList = Student::all();
        return view('student.student',compact('studentList'));
    }

    /** index page student grid */
    public function studentGrid()
    {
        $studentList = Student::all();
        return view('student.student-grid',compact('studentList'));
    }

    /** student add page */
    public function studentAdd()
    {
        $classes = ClassRoom::all(); // Fetch all classes
        return view('student.add-student', compact('classes'));
    }
    
    public function studentSave(Request $request)
{
    $request->validate([
        'first_name'             => 'required|string',
        'last_name'              => 'required|string',
        'gender'                 => 'required|not_in:0',
        'date_of_birth'          => 'required|string',
        'religion'               => 'required|string',
        'email'                  => 'required|email',
        'phone_number'           => 'required|string',
        'stud_username'          => 'required|string',
        'password'               => 'required|string|min:8|confirmed',
        'password_confirmation'  => 'required',
        'address'                => 'required|string',
        'city'                   => 'required|string',
        'state'                  => 'required|string',
        'zip_code'               => 'required|string',
        'country'                => 'required|string',
        'status'                 => 'required|string',
        'class_id'               => 'required|exists:class,id', // Validate class_id exists in class table
        'upload'                 => 'required|mimes:jpeg,png,jpg,gif,doc,docx,ppt,pptx,csv,txt,xlx,xls,pdf|max:18000' // Validate image upload
    ]);

    try {
        DB::beginTransaction(); // Start the transaction

        $dt        = Carbon::now();
        $todayDate = $dt->toDayDateTimeString();

        // Check if the student with the provided admission_id already exists
        if (Student::where('admission_id', $request->admission_id)->exists()) {
            Toastr::error('Student with the provided admission ID already exists :(', 'Error');
            return redirect()->back();
        }

        $filePath = null;
        if ($request->hasFile('upload')) {
            $file = $request->file('upload');
            $fileName = time() . '.' . $file->getClientOriginalExtension();
            $filePath  = $file->storeAs('profile', $fileName, 'public'); // Store the file in the 'public/profile' directory
        }

        // Save record in User table
        $user = User::create([
            'name'        => $request->first_name,
            'email'       => $request->email,
            'join_date'   => $todayDate,
            'role_name'   => 'Student',
            'status'      => $request->status,
            'avatar'      => $filePath, 
            'address'     => $request->address,
            'city'        => $request->city,
            'state'       => $request->state,
            'zip_code'    => $request->zip_code,
            'country'     => $request->country,
            'phone_number'=> $request->phone_number,
            'password'    => Hash::make($request->password),
        ]);

        // Save record in Student table
        $studentSave = new Student;
        $studentSave->class_id         = $request->class_id;
        $studentSave->admission_id     = $request->admission_id;
        $studentSave->join_date        = $todayDate;
        $studentSave->first_name       = $request->first_name;
        $studentSave->last_name        = $request->last_name;
        $studentSave->gender           = $request->gender;
        $studentSave->date_of_birth    = $request->date_of_birth;
        $studentSave->religion         = $request->religion;
        $studentSave->email            = $request->email;
        $studentSave->password         = Hash::make($request->password);
        $studentSave->stud_username    = $request->stud_username;
        $studentSave->address          = $request->address;
        $studentSave->city             = $request->city;
        $studentSave->state            = $request->state;
        $studentSave->zip_code         = $request->zip_code;
        $studentSave->country          = $request->country;
        $studentSave->phone_number     = $request->phone_number;
        $studentSave->status           = $request->status;
        $studentSave->upload           = $filePath; // Save the image path
        $studentSave->user_id          = $user->id; // Save the user ID
        $studentSave->save();

        // Update user with student ID
        $user->stud_id = $studentSave->id;
        $user->save();

        DB::commit(); // Commit the transaction

        Toastr::success('Student has been added successfully :)', 'Success');
        return redirect()->route('student/list');
    } catch (\Exception $e) {
        \Log::error('Error saving student: ' . $e->getMessage());
        DB::rollback();
        Toastr::error('Failed to add a new student record :(', 'Error');
        return redirect()->back();
    }
}

    
    

    /** edit record */
    public function studentEdit($id)
    {
        $studentEdit = Student::findOrFail($id);
        $classes = ClassRoom::all(); // Fetch all classes
        $passwordHash = $studentEdit->password; // Retrieve the password hash from the database
        return view('student.edit-student', compact('studentEdit', 'classes', 'passwordHash'));
    }



//STUDENT UPDATE
public function studentUpdate(Request $request)
{
    $request->validate([
        'admission_id'    => 'required|string',
        'first_name'      => 'required|string',
        'last_name'       => 'required|string',
        'gender'          => 'required|string',
        'date_of_birth'   => 'required|string',
        'phone_number'    => 'required|string',
        'religion'        => 'required|string',
        'email'           => 'required|email|unique:students,email,'.$request->id,
        'password'        => 'sometimes|min:8|confirmed',
        'stud_username'   => 'required|string|unique:students,stud_username,'.$request->id,
        'address'         => 'required|string',
        'city'            => 'required|string',
        'state'           => 'required|string',
        'zip_code'        => 'required|string',
        'country'         => 'required|string',
        'status'          => 'required|string',
        'class_id'        => 'required|exists:class,id',
    ]);

    DB::beginTransaction();

    try {
        // Find the existing student record
        $existingStudent = Student::find($request->id);

        if (!$existingStudent) {
            Toastr::error('Student not found :(', 'Error');
            return redirect()->back();
        }

        // Update student fields
        $existingStudent->class_id         = $request->class_id;
        $existingStudent->admission_id     = $request->admission_id;
        $existingStudent->first_name       = $request->first_name;
        $existingStudent->last_name        = $request->last_name;
        $existingStudent->gender           = $request->gender;
        $existingStudent->date_of_birth    = $request->date_of_birth;
        $existingStudent->phone_number     = $request->phone_number;
        $existingStudent->religion         = $request->religion;
        $existingStudent->email            = $request->email;
        if ($request->filled('password')) {
            $existingStudent->password     = Hash::make($request->password);
        }
        $existingStudent->stud_username    = $request->stud_username;
        $existingStudent->address          = $request->address;
        $existingStudent->city             = $request->city;
        $existingStudent->state            = $request->state;
        $existingStudent->zip_code         = $request->zip_code;
        $existingStudent->country          = $request->country;
        $existingStudent->status           = $request->status;
        $existingStudent->save();

        // Update corresponding user record
        $user = User::where('email', $existingStudent->email)->first();
        if ($user) {
            $user->name = $request->first_name;
            $user->email = $request->email;
            $user->status = $request->status;
            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();
        }

        DB::commit();
        Toastr::success('Student has been updated successfully :)', 'Success');
        return redirect()->route('student/list');
    } catch (\Exception $e) {
        \Log::error($e);
        DB::rollback();
        Toastr::error('Failed to update student :(', 'Error');
        return redirect()->back();
    }
}




 /** student delete */
 public function studentDelete($id)
 {
     DB::beginTransaction();
     try {
         // Find the student by ID
         $student = Student::find($id);

         // Find the user by email
         $user = User::where('email', $student->email)->first();

         if ($user) {
             $user->delete(); // Delete the user record
         }

         $student->delete(); // Delete the student record

         DB::commit();
         Toastr::success('Deleted record successfully :)','Success');
         return redirect()->route('student/list');
     } catch(\Exception $e) {
         DB::rollback();
         Toastr::error('Failed to delete record :(', 'Error');
         return redirect()->back();
     }
 }

    /** student profile page */
    public function studentProfile($id)
    {
        $studentProfile = Student::where('id',$id)->first();
        return view('student.student-profile',compact('studentProfile'));
    }
}
