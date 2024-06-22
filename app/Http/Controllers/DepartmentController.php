<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Teacher;
use App\Models\Department;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class DepartmentController extends Controller
{
    /** Department add page */
    public function departmentAdd()
    {
        $teachers = Teacher::all(); // Fetch all departments
        return view('department.add-department', compact('teachers'));
    }

 // Controller Method
public function departmentList()
{
    $departmentList = Department::with('hodTeacher')->get(); // Eager load the hodTeacher relationship
    return view('department.list-department', compact('departmentList'));
}

    

    /** Save department record */
    public function departmentSave(Request $request)
    {
        $request->validate([
            'dept_id'   => 'required|string',
            'dept_name' => 'required|string',
            'hod'       => 'nullable|exists:teachers,id', // Validate head of department exists in teachers table
        ]);
    
        try {
            DB::beginTransaction();
    
            // Check if the department with the given dept_id already exists
            if (Department::where('dept_id', $request->dept_id)->exists()) {
                Toastr::error('Department with the provided ID already exists :(', 'Error');
                return redirect()->back();
            }
    
            // If not exists, proceed with saving the department
            $department = new Department;
            $department->dept_id   = $request->dept_id;
            $department->dept_name = $request->dept_name;
            $department->hod       = $request->hod; // Assign head of department ID
            $department->save();
    
            DB::commit();
    
            Toastr::success('Department has been added successfully :)', 'Success');
            return redirect()->route('department/list/page');
        } catch (\Exception $e) {
            \Log::error($e);
            DB::rollback();
    
            Toastr::error('Failed to add a new department :('. $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
    

    /** View for editing department */
    public function departmentEdit($d_id)
    {
        $teachers = Teacher::all();
        $departmentEdit = Department::findOrFail($d_id);
        return view('department.edit-department', compact('teachers','departmentEdit'));
    }

    public function departmentUpdate(Request $request)
    {
        $request->validate([
            'dept_id'   => 'required|string',
            'dept_name' => 'required|string',
            'hod'       => 'required|exists:teachers,id', // Validate hod exists in teachers table
        ]);
    
        DB::beginTransaction();
    
        try {
            // Find the existing department by its ID
            $existingDepartment = Department::find($request->d_id);
    
            // If the department doesn't exist, return an error
            if (!$existingDepartment) {
                Toastr::error('Department not found :(', 'Error');
                return redirect()->back();
            }
    
            // Update department fields
            $existingDepartment->dept_id   = $request->dept_id;
            $existingDepartment->dept_name = $request->dept_name;
            $existingDepartment->hod       = $request->hod; // Assign hod directly
    
            // Save the updated department
            $existingDepartment->save();
    
            DB::commit();
            Toastr::success('Department has been updated successfully :)', 'Success');
            return redirect()->route('department/list/page');
        } catch (\Exception $e) {
            \Log::error($e);
            DB::rollback();
            Toastr::error('Failed to update department :(', 'Error');
            return redirect()->back();
        }
    }
    
    


   /** Department delete */
public function departmentDelete(Request $request)
{
    DB::beginTransaction();
    try {
        // Delete the department record by ID
        Department::destroy($request->d_id);

        DB::commit();
        Toastr::success('Department deleted successfully :)', 'Success');
        return redirect()->back();
    } catch (\Exception $e) {
        \Log::error($e);
        DB::rollback();
        Toastr::error('Failed to delete department :(', 'Error');
        return redirect()->back();
    }
}

}
