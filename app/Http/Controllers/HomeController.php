<?php

namespace App\Http\Controllers;

use DB;
use Auth;
use Session;
use App\Models\Student;
use App\Models\Admin;
use App\Models\User;
use App\Models\Teacher;
use Illuminate\Http\Request;

use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;
use App\Rules\MatchOldPassword;
use Illuminate\Http\UploadedFile;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
    /** home dashboard */
    public function index()
    {
        return view('dashboard.maindash');
    }

/** profile user */
public function userProfile()
{
    $user = Auth::user(); // Fetch the authenticated user
    return view('dashboard.profile', compact('user'));
}


  /** admin dashboard */
  public function adminDashboardIndex()
  {
     // Calculate class averages
     $classAverages = StudentDummy::select('student_dummies.class', 'subject_dummies.name as subject')
     ->selectRaw('AVG(carry_mark_dummies.carry_mark) as average_carry_mark')
     ->join('carry_mark_dummies', 'student_dummies.id', '=', 'carry_mark_dummies.student_id')
     ->join('subject_dummies', 'carry_mark_dummies.subject_id', '=', 'subject_dummies.id')
     ->groupBy('student_dummies.class', 'subject_dummies.name')
     ->get()
     ->groupBy('class');

// Calculate form averages
$formAverages = StudentDummy::selectRaw("SUBSTRING_INDEX(form, ' ', -1) as form_number")
 ->selectRaw('subject_dummies.name as subject, AVG(carry_mark_dummies.carry_mark) as average_carry_mark')
 ->join('carry_mark_dummies', 'student_dummies.id', '=', 'carry_mark_dummies.student_id')
 ->join('subject_dummies', 'carry_mark_dummies.subject_id', '=', 'subject_dummies.id')
 ->groupBy('form_number', 'subject_dummies.name')
 ->get()
 ->groupBy('form_number');

 // Calculate subject averages
 $subjectAverages = SubjectDummy::select('subject_dummies.name')
     ->selectRaw('AVG(carry_mark_dummies.carry_mark) as average_carry_mark')
     ->join('carry_mark_dummies', 'subject_dummies.id', '=', 'carry_mark_dummies.subject_id')
     ->groupBy('subject_dummies.id')
     ->get();
      return view('dashboard.admindash',compact('classAverages', 'formAverages', 'subjectAverages'));
  }




    /** teacher dashboard */
    public function teacherDashboardIndex()
    {
        return view('dashboard.teacher_dashboard');
    }

    /** student dashboard */
    public function studentDashboardIndex()
    {
        return view('dashboard.student_dashboard');
    }
}
