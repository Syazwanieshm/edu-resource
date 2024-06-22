<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Department;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class DepartmentController extends Controller
{

    /** department add page */
    public function departmentAdd()
    {
        return view('department.add-department');
    }

     /** index page department list */
     public function departmentList()
     {
         $departmentList = Department::all();
         return view('department.list-department', compact('departmentList'));
     }
     public function departmentSave(Request $request)
     {
         $request->validate([
             'dept_id'   => 'required|string',
             'dept_name' => 'required|string',
             'hod'       => 'required|string',
         ]);
     
         try {
             DB::beginTransaction(); // Start the transaction
     
             // Check if the department with the given dept_id already exists
             if (Department::where('dept_id', $request->dept_id)->exists()) {
                 Toastr::error('Department with the provided ID already exists :(', 'Error');
                 return redirect()->back();
             }
     
             // If not exists, proceed with saving the department
             $department = new Department;
             $department->dept_id   = $request->dept_id;
             $department->dept_name = $request->dept_name;
             $department->hod       = $request->hod;
             $department->save();
     
             DB::commit(); // Commit the transaction
     
             Toastr::success('Department has been added successfully :)', 'Success');
             return redirect()->route('department/list/page');
         } catch (\Exception $e) {
            \Log::error($e);
             DB::rollback(); // Rollback the transaction in case of an exception
     
             Toastr::error('Failed to add a new department :('. $e->getMessage(), 'Error');
             return redirect()->back();
         }
     }
     
     

    /** view for edit department */
    public function departmentEdit($dept_id)
    {
        $departmentEdit = Department::where('dept_id', $dept_id)->first();
        return view('department.edit-department', compact('departmentEdit'));
    }

    /** update department record */
    public function departmentUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $departmentUpdate = [
                'dept_id'       =>  $request->dept_id,
                'department_name' => $request->dept_name,
                'hod'             => $request->hod,
            ];
            Department::where('dept_id', $request->dept_id)->update($departmentUpdate);

            Toastr::success('Department has been updated successfully :)', 'Success');
            DB::commit();
            return redirect()->route('department/list/page');

        } catch (\Exception $e) {
            \Log::error($e);
            DB::rollback();
            Toastr::error('Failed to update department :(', 'Error');
            return redirect()->back();
        }
    }

    /** department delete */
    public function departmentDelete(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!empty($request->id)) {
                Department::destroy($request->id);
                DB::commit();
                Toastr::success('Department deleted successfully :)', 'Success');
                return redirect()->back();
            }

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to delete department :(', 'Error');
            return redirect()->back();
        }
    }

}