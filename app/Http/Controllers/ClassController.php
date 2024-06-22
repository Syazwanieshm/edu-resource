<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\Teacher; 
use App\Models\class_teacher;
use App\Models\class_subject;
use App\Models\SubjectTeacher;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;



use Illuminate\Support\Facades\Redirect;

class ClassController extends Controller
{
    /** class add page */
    public function classAdd()
    {
        $teachers = Teacher::all(); // Retrieve all teachers
        $subjectView = Subject::all(); // Retrieve all subjects
        return view('class.add_class', compact('teachers', 'subjectView')); // Pass both teachers and subjectView variables to the view
    }

     /** index page class list */
     public function classList()
     {
         $classList = ClassRoom::all();
         return view('class.list_class', compact('classList'));
     }

     /** SAVE DATA */
   
     public function classSave(Request $request)
{
    $request->validate([
        'class_id' => 'required|string|unique:class,class_id',
        'class_name' => 'required|string',
        'class_desc' => 'required|string',
        'class_teacher' => 'required|integer',
        'sub_id' => 'required|array',
        'sub_id.*' => 'integer',
        'teacher_id' => 'required|array',
        'teacher_id.*' => 'integer',
    ]);

    try {
        DB::beginTransaction(); // Start the transaction

        // Create a new class
        $class = ClassRoom::create([
            'class_id' => $request->class_id,
            'class_name' => $request->class_name,
            'class_desc' => $request->class_desc,
        ]);

        // Save subjects for the class in the pivot table
        foreach ($request->sub_id as $index => $subId) {
            $class->subjects()->attach($subId, ['teacher_id' => $request->teacher_id[$index]]);
        }

        // Save classroom teacher for the class
        $class->teachers()->sync([$request->class_teacher => ['teacher_type' => 'Classroom Teacher']]);

        DB::commit(); // Commit the transaction

        Toastr::success('Class has been added successfully :)', 'Success');
        return redirect()->route('class/list/page');
    } catch (\Exception $e) {
        DB::rollback(); // Rollback the transaction in case of an exception

        Toastr::error('Failed to add a new class :('. $e->getMessage(), 'Error');
        return redirect()->back();
    }
}

     

     public function classEdit($id)
     {
         $classEdit = ClassRoom::with(['subjects', 'teachers', 'teachers.department'])->find($id);
     
         if (!$classEdit) {
             return redirect()->back()->with('error', 'Class not found.');
         }
     
         $teachers = Teacher::all(); // Retrieve all teachers
         $subjectView = Subject::all(); // Retrieve all subjects
     
         return view('class.edit_class', compact('classEdit', 'teachers', 'subjectView'));
     }
     
     
     public function classUpdate(Request $request)
     {
         $request->validate([
             'id' => 'required|integer',
             'class_id' => 'required|string',
             'class_name' => 'required|string',
             'class_desc' => 'required|string',
             'class_teacher' => 'required|integer',
             'sub_id' => 'nullable|array',
             'sub_id.*' => 'integer',
             'teacher_id' => 'nullable|array',
             'teacher_id.*' => 'integer',
         ]);
     
         try {
             $class = ClassRoom::findOrFail($request->id);
     
             $class->update([
                 'class_id' => $request->class_id,
                 'class_name' => $request->class_name,
                 'class_desc' => $request->class_desc,
             ]);
     
             // Update subjects and teachers
             if ($request->has('sub_id') && $request->has('teacher_id')) {
                 $subjects = [];
                 foreach ($request->sub_id as $index => $subId) {
                     $teacherId = $request->teacher_id[$index] ?? null;
                     $subjects[$subId] = ['teacher_id' => $teacherId];
                 }
     
                 // Sync the subjects and teachers
                 $class->subjects()->sync($subjects);
             }
     
             // Update the classroom teacher for the class
             $class->teachers()->sync([$request->class_teacher => ['teacher_type' => 'Classroom Teacher']]);
     
             Toastr::success('Class has been updated successfully :)', 'Success');
             return redirect()->route('class/list/page');
     
         } catch (\Exception $e) {
             Toastr::error('Failed to update class :('. $e->getMessage(), 'Error');
             return redirect()->back();
         }
     }
     
    
     


    /** class delete */
public function classDelete(Request $request)
{
    DB::beginTransaction();
    try {
        if (!empty($request->id)) {
            // Find the class
            $class = ClassRoom::find($request->id);
            
            // Detach all subjects related to this class
            $class->subjects()->detach();
            
            // Delete the class
            $class->delete();

            DB::commit();
            Toastr::success('Class deleted successfully :)', 'Success');
            return redirect()->back();
        }
    } catch (\Exception $e) {
        DB::rollback();
        Toastr::error('Failed to delete class :(', 'Error');
        return redirect()->back();
    }
}


public function showTeacherClassButton()
{ 
    return view('classroom.button_teacher');
}

public function teacherAssignments($teacherId)
{
    try {
        // Find the teacher
        $teacher = Teacher::findOrFail($teacherId);

        // Retrieve classes assigned to the teacher
        $assignedClasses = $teacher->classes()->with('subjects')->get();

        // Prepare the data to return
        $classSubjects = [];
        foreach ($assignedClasses as $class) {
            $subjects = $class->subjects->pluck('subject_name')->toArray();
            $classSubjects[] = [
                'class_name' => $class->class_name,
                'subjects' => $subjects,
            ];
        }

        // Pass $teacherId and $classSubjects to the view
        return view('classroom.subjectList_Teacher', compact('teacherId', 'classSubjects'));

    } catch (\Exception $e) {
        // Handle exceptions
        Toastr::error('Failed to retrieve teacher assignments :('. $e->getMessage(), 'Error');
        return redirect()->back();
    }
}


   



}
