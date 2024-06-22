<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use Auth;
use Session;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Student;
use App\Models\Teacher;
use App\Models\ClassRoom;
use App\Models\Department;
use App\Models\Admin;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Rules\MatchOldPassword;
use Illuminate\Http\UploadedFile;


class UserManagementController extends Controller
{
    // index page
    public function index()
    {
        $users = User::all();
        return view('usermanagement.list_users',compact('users'));
    }

// Assume you have a controller method that handles the form submission
public function showAddRole(Request $request)
{
    $users = User::all();
    $student = Student::all();
    $teacher = Teacher::all();

    return view('usermanagement.add_role', compact('users','teacher','student'));

}

// Assume you have a controller method that handles the form submission
public function addRole(Request $request)
{
    // Validate the form data
    $validatedData = $request->validate([
        'role_name' => 'required',
        // Add other validation rules as needed
    ]);

    // Based on the role name, redirect to the corresponding form
    switch ($validatedData['role_name']) {
        case 'Admin':
            return redirect()->route('admin/add/page');
        case 'Teachers':
            return redirect()->route('teacher/add/page');
        case 'Student':
            return redirect()->route('student/add/page');
        default:
            // Handle invalid role name
            return back()->withErrors(['role_name' => 'Invalid role name']);
    }
}

public function userView($id)
{
    // Assuming 'role' is a column in your users table
    $user = User::findOrFail($id); // Retrieve the user by ID
    
    // Determine the role of the user
    $role = $user->role_name;

    // Redirect to appropriate edit form based on role
    if ($role === 'Admin') {
        //$admin = Admin::findOrFail($id); // Retrieve the user by ID
        $admin = Admin::all(); // Retrieve the user by ID
        //$admin = Admin::all(); // Retrieve the user by ID
        return view('usermanagement.edit_admin', compact('user'));
    } elseif ($role === 'Teachers') {
        return view('usermanagement.edit_teacher', compact('user'));
    } elseif ($role === 'Student') {
        return view('usermanagement.edit_student', compact('user'));
    } else {
        // Handle other roles or cases if needed
        abort(404); // Or redirect to a general edit form
    }
}


    //------------------------------------------------------------------------------------------------------------------------------------------------------------------
    /** admin add page */
    public function adminAdd()
    {
        $admin = Admin::all(); // Fetch all admin
        return view('usermanagement.admin_form', compact('admin'));
    }
    public function adminSave(Request $request)
    {
        $request->validate([
            'first_name'             => 'required|string',
            'last_name'              => 'required|string',
            'gender'                 => 'required|not_in:0',
            'date_of_birth'          => 'required|string',
            'religion'               => 'required|string',
            'email'                  => 'required|email',
            'phone_number'           => 'required|string',
            'password'               => 'required|string|min:8|confirmed',
            'password_confirmation'  => 'required',
            'address'                => 'required|string',
            'city'                   => 'required|string',
            'state'                  => 'required|string',
            'zip_code'               => 'required|string',
            'country'                => 'required|string',
            'status'                 => 'required|string',
            'upload'                 => 'required|mimes:jpeg,png,jpg,gif,doc,docx,ppt,pptx,csv,txt,xlx,xls,pdf|max:18000' // Validate image upload
        ]);
    
        try {
            DB::beginTransaction(); // Start the transaction
    
            $dt        = Carbon::now();
            $todayDate = $dt->toDayDateTimeString();
    
            // Check if the student with the provided admission_id already exists
            if (Admin::where('admission_id', $request->admission_id)->exists()) {
                Toastr::error('Student with the provided admission ID already exists :(', 'Error');
                return redirect()->back();
            }
    
            $filePath = null;
            if ($request->hasFile('upload')) {
                $file = $request->file('upload');
                $fileName = time() . '.' . $file->getClientOriginalExtension();
                $filePath  = $file->storeAs('profile', $fileName, 'public'); // Store the file in the 'public/images' directory
            }
    
            // Save record in User table
            $user = User::create([
                'name'      => $request->first_name,
                'email'     => $request->email,
                'join_date' => $todayDate,
                'role_name' => 'Admin',
                'status'    => $request->status,
                'password'  => Hash::make($request->password),
                'avatar'=> $request->file_path,
            ]);
    
            // Save record in Admin table
            $adminSave = new Admin;
            $adminSave->admission_id     = $request->admission_id;
            $adminSave->join_date        = $todayDate;
            $adminSave->first_name       = $request->first_name;
            $adminSave->last_name        = $request->last_name;
            $adminSave->gender           = $request->gender;
            $adminSave->date_of_birth    = $request->date_of_birth;
            $adminSave->religion         = $request->religion;
            $adminSave->email            = $request->email;
            $adminSave->password         = $request->password;
            $adminSave->address          = $request->address;
            $adminSave->city             = $request->city;
            $adminSave->state            = $request->state;
            $adminSave->zip_code         = $request->zip_code;
            $adminSave->country          = $request->country;
            $adminSave->phone_number     = $request->phone_number;
            $adminSave->status           = $request->status;
            $adminSave->upload           = $filePath; // Save the image path
            $adminSave->save();
    
            DB::commit(); // Commit the transaction
    
            Toastr::success('Has been added successfully :)', 'Success');
            return redirect()->route('list/users');
        } catch (\Exception $e) {
            \Log::info($request->all());
            DB::rollback();
            Toastr::error('Failed to add a new record :(', 'Error');
            return redirect()->back();
        }
    }

     //------------------------------------------------------------------------------------------------------------------------------------------------------------------


     /** student add page */
     public function studentAdd()
     {
         $classes = ClassRoom::all(); // Fetch all classes
         return view('usermanagement.student_form', compact('classes'));
     }

//ADD STUDENT
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
                $filePath  = $file->storeAs('profile', $fileName, 'public'); // Store the file in the 'public/images' directory
            }
    
            // Save record in User table
            $user = User::create([
                'name'      => $request->first_name,
                'email'     => $request->email,
                'join_date' => $todayDate,
                'role_name' => 'Student',
                'status'    => $request->status,
                'password'  => Hash::make($request->password),
                'avatar'=> $request->file_path,
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
            $studentSave->password         = $request->password;
            $studentSave->stud_username    = $request->stud_username;
            $studentSave->address          = $request->address;
            $studentSave->city             = $request->city;
            $studentSave->state            = $request->state;
            $studentSave->zip_code         = $request->zip_code;
            $studentSave->country          = $request->country;
            $studentSave->phone_number     = $request->phone_number;
            $studentSave->status           = $request->status;
            $studentSave->upload           = $filePath; // Save the image path
            $studentSave->save();
    
            DB::commit(); // Commit the transaction
    
            Toastr::success('Has been added successfully :)', 'Success');
            return redirect()->route('list/users');
        } catch (\Exception $e) {
            \Log::info($request->all());
            DB::rollback();
            Toastr::error('Failed to add a new record :(', 'Error');
            return redirect()->back();
        }
    }
    
    //ADD TEACHER
    public function teacherAdd()
    {
        $departments = Department::all(); // Fetch all departments
        return view('usermanagement.teacher_form', compact('departments'));
    }

   //SAVE TEACHER RECORD
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
        'dept_id' => 'required|exists:department,d_id', 
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
            'role_name' => 'Teacher',
            'password'  => $password,
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
        return redirect()->route('list/users');
    } catch(\Exception $e) {
        \Log::info($e);
        DB::rollback();
        Toastr::error('fail, Add new record  :)','Error');
        return redirect()->back();
    }
}


/** user Update */
public function userUpdate(Request $request)
{
    $request->validate([
        'user_id'      => 'required|string',
        'name'         => 'required|string',
        'email'        => 'required|email|unique:users,email,' . $request->user_id,
        'role_name'    => 'required|string',
        'position'     => 'required|string',
        'phone_number' => 'required|string',
        'department'   => 'required|string',
        'status'       => 'required|string',
        'avatar'       => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048', // Validate image
    ]);

    DB::beginTransaction();
    try {
        if (Session::get('role_name') === 'Admin') {
            // Find the user by ID
            $existingUser = User::findOrFail($request->user_id);

            // Handle the image upload if a new image is provided
            if ($request->hasFile('avatar')) {
                // Delete the old image if it exists and is not the default image
                if ($existingUser->avatar != 'photo_defaults.jpg' && Storage::disk('public')->exists('images' . $existingUser->avatar)) {
                    Storage::disk('public')->delete('images' . $existingUser->avatar);
                }

                // Upload the new image
                $image = $request->file('avatar');
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->storeAs('images', $imageName, 'public');
                $existingUser->avatar = $imagePath; // Update the image path in the database
            }

            // Update the user fields
            $existingUser->name         = $request->name;
            $existingUser->email        = $request->email;
            $existingUser->role_name    = $request->role_name;
            $existingUser->position     = $request->position;
            $existingUser->phone_number = $request->phone_number;
            $existingUser->department   = $request->department;
            $existingUser->status       = $request->status;

            // Log the user object before saving
            Log::info('User before save:', ['user' => $existingUser]);

            // Save the updated user
            $existingUser->save();

            // Log success message
            Log::info('User updated successfully:', ['user_id' => $existingUser->user_id]);

            DB::commit(); // Commit the transaction
            Toastr::success('User has been updated successfully :)', 'Success');
            return redirect()->back();
        } else {
            Toastr::error('Unauthorized action :(', 'Error');
            return redirect()->back();
        }
    } catch (\Exception $e) {
        // Log the exception
        Log::error('Failed to update user:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
        
        DB::rollback(); // Rollback the transaction
        Toastr::error('Failed to update user :(', 'Error');
        return redirect()->back();
    }
}


     // delete user
     public function userDelete($id)
     {
         try {
             DB::beginTransaction();
 
             $user = User::find($id);
 
             if (!$user) {
                 Toastr::error('User not found :(', 'Error');
                 return redirect()->back();
             }
 
             $role = $user->role_name;
 
             switch ($role) {
                 case 'Student':
                     $relatedRecord = Student::where('email', $user->email)->first();
                     break;
                 case 'Teacher':
                     $relatedRecord = Teacher::where('email', $user->email)->first();
                     break;
                 case 'Admin':
                     $relatedRecord = Admin::where('email', $user->email)->first();
                     break;
                 default:
                     $relatedRecord = null;
             }
 
             if ($relatedRecord) {
                 $relatedRecord->delete();
             }
 
             $user->delete();
 
             DB::commit();
 
             Toastr::success('User has been deleted successfully :)', 'Success');
             return redirect()->route('list/users');
         } catch (\Exception $e) {
             Log::error($e->getMessage());
             DB::rollback();
             Toastr::error('Failed to delete the user :(', 'Error');
             return redirect()->back();
         }
     }
     

     public function changePassword(Request $request)
     {
         // Validate the request inputs
         $request->validate([
             'current_password'     => ['required', new MatchOldPassword],
             'new_password'         => ['required', 'min:8'],
             'new_confirm_password' => ['same:new_password'],
         ]);
     
         // Get the authenticated user
         $user = auth()->user();
     
         // Check if the current password matches the stored password
         if (!Hash::check($request->current_password, $user->password)) {
             // If passwords don't match, redirect back with an error message
             return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
         }
     
         // If validation passes, update the user's password
         $user->password = Hash::make($request->new_password);
         $user->save();
     
         // Commit the changes to the database
         DB::commit();
     
         // Display a success message
         Toastr::success('Password changed successfully :)', 'Success');
         
         // Redirect to the intended page (home)
         return redirect()->intended('home');
     }

}
