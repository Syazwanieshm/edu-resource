<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Subject;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;

class SubjectController extends Controller
{
    /** subject add page */
    public function subjectAdd()
    {
        return view('subject.add_subject');
    }

     /** index page subject list */
     public function subjectList()
     {
         $subjectList = Subject::all();
         return view('subject.list_subject', compact('subjectList'));
     }

     //SAVE RECORD
     public function subjectSave(Request $request)
     {
         $request->validate([
             //'sub_id'   => 'required|string',
             'sub_name' => 'required|string',
             'description'       => 'required|string',
         ]);
     
         try {
             DB::beginTransaction(); // Start the transaction
     
             // Check if the subject with the given sub_id already exists
             if (Subject::where('sub_id', $request->sub_id)->exists()) {
                 Toastr::error('Subject with the provided ID already exists :(', 'Error');
                 return redirect()->back();
             }
             $sub_id = DB::table('subject')->select('sub_id')->orderBy('id','DESC')->first();
             // If not exists, proceed with saving the subject
             $subject = new Subject;
             $subject->sub_id   = $request->sub_id;
             $subject->sub_name = $request->sub_name;
             $subject->description      = $request->description;
             $subject->save();
     
             DB::commit(); // Commit the transaction
     
             Toastr::success('Subject has been added successfully :)', 'Success');
             return redirect()->route('subject/list/page');
         } catch (\Exception $e) {
            \Log::error($e);
             DB::rollback(); // Rollback the transaction in case of an exception
     
             Toastr::error('Failed to add a new subject :('. $e->getMessage(), 'Error');
             return redirect()->back();
         }
     }
     
     

    /** view for edit subject */
    public function subjectEdit($id)
    {
        $subjectEdit = Subject::where('id', $id)->first();
        return view('subject.edit_subject', compact('subjectEdit'));
    }

    /** update subject record */
    public function subjectUpdate(Request $request)
    {
        DB::beginTransaction();
        try {
            $subjectUpdate = [
                'sub_id'       =>  $request->sub_id,
                'sub_name' => $request->sub_name,
                'description'             => $request->description,
            ];
            Subject::where('id', $request->id)->update($subjectUpdate);

            Toastr::success('Subject has been updated successfully :)', 'Success');
            DB::commit();
            return redirect()->route('subject/list/page');

        } catch (\Exception $e) {
            \Log::error($e);
            DB::rollback();
            Toastr::error('Failed to update subject :(', 'Error');
            return redirect()->back();
        }
    }

    /** subject delete */
    public function subjectDelete(Request $request)
    {
        DB::beginTransaction();
        try {

            if (!empty($request->id)) {
                Subject::destroy($request->id);
                DB::commit();
                Toastr::success('Subject deleted successfully :)', 'Success');
                return redirect()->back();
            }

        } catch (\Exception $e) {
            DB::rollback();
            Toastr::error('Failed to delete subject :(', 'Error');
            return redirect()->back();
        }
    }

    public function subjectView()
    {
        // Fetch the list of subjects from the database
        $subjectView = Subject::pluck('sub_name', 'sub_id');
    
        return view('class.add_class', compact('subjectView'));
    }

}