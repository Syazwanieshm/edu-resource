<?php

namespace App\Http\Controllers;

use DB;
use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use App\Models\Teacher;
use App\Models\Material;
use App\Models\Task;
use App\Models\ClassRoom;
use App\Models\Topic;
use App\Models\TopicTask;
use App\Models\Student;
use App\Models\class_subject;
use App\Models\class_teacher;
use App\Models\ResourcesMaterial;

use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class SidebarController extends Controller
{
    public function sidebarData()
    {
        // Assuming you're fetching the logged-in student
        $student = Student::with('classroom.subjects')->find(Auth::id());

        return view('sidebar', compact('student'));
    }

    public function loadSidebar()
    {
        // Call the subjectList method to get teaching details
        $teachingDetails = $this->subjectList();
        
        return view('sidebar.sidebar', compact('teachingDetails'));
    }

    private function subjectList()
    {
        // Get the currently authenticated teacher
        $teacher = Auth::guard('teachers')->user();

        if (!$teacher) {
            Toastr::error('You are not logged in as a teacher');
            return redirect()->back();
        }

        // Retrieve all classes related to the teacher
        $classes = $teacher->classRooms;

        // Initialize an empty array to hold class names and their subjects
        $teachingDetails = [];

        foreach ($classes as $class) {
            $className = $class->class_name;
            $subjects = $class->subjects()->wherePivot('teacher_id', $teacher->id)->get();
            
            $teachingDetails[] = [
                'className' => $className,
                'subjects' => $subjects
            ];
        }

        return $teachingDetails;
    }

    //------------------------------------------------------------------------
    public function sidebar()
{
    // Retrieve data based on the user's role
    $role = Session::get('role_name');

    if ($role === 'Admin') {
        $data = [
            'users' => User::all(),
            'tudents' => Student::all(),
            'teachers' => Teacher::all(),
            //...
        ];
    } elseif ($role === 'Teachers') {
        $data = [
            'classes' => ClassRoom::where('id', auth()->user()->id)->get(),
            'resources' => ResourcesMaterial::where('id', auth()->user()->id)->get(),
            //...
        ];
    } elseif ($role === 'Student') {
        $data = [
            'className' => ClassName::where('student_id', auth()->user()->id)->first(),
            'subjects' => Subject::where('class_id', $data['className']->id)->get(),
            //...
        ];
    }

    return view('sidebar.sidebar', $data);
}

}