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
use App\Models\Subject;
use App\Models\material_student;
use App\Models\task_student;
use App\Models\StudentWork;
use App\Models\TaskStudentWork;
use App\Models\Grade;

use Illuminate\Support\Facades\Log; // Import Log facade

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class StudentClassController extends Controller
{
    //MAIN IN STUDENT VIEW eng
    public function main()
    {
        $class = ClassRoom ::all();
        return view('classroom.stud_classroom');
    }

      //MAIN IN STUDENT VIEW math
      public function mainMath()
      {
          $class = ClassRoom ::all();
          return view('classroom.stud_classroom_math');
      }

        //MAIN IN STUDENT VIEW science
        public function mainSn()
        {
            $class = ClassRoom ::all();
            return view('classroom.stud_classroom_sn');
        }
        
          //MAIN IN STUDENT VIEW history
          public function mainHtr()
          {
              $class = ClassRoom ::all();
              return view('classroom.stud_classroom_htr');
          }
  


    //ANNOUNCEMENT IN STUDENT VIEW eng
    public function announcement()
    {
        return view('classroom.stud_ann');
    }

    

    //material eng
    public function material(Request $request)
    {
        $topics = Topic::all();
        $selectedTopicId = $request->query('topic_id');
        $studentId = auth()->user()->stud_id; // assuming you're using Laravel's built-in auth system
    
        if ($selectedTopicId) {
            $selectedTopic = Topic::find($selectedTopicId);
            $selectedTopicName = $selectedTopic->name?? 'All Topics';
        } else {
            $selectedTopicName = 'All Topics';
        }
    
        //  show materials they are assigned to by retrieve the materials using student_id in material_student database.
        $materialsStud = Material::whereHas('students', function ($query) use ($studentId, $selectedTopicId) {
            $query->where('material_student.student_id', $studentId);
            if ($selectedTopicId) {
                $query->where('materials.topic_id', $selectedTopicId);
            }
        })
        ->select('title', 'created_at', 'id')
        ->orderBy('created_at', 'desc')
        ->get();
    
        return view('classroom.stud_material', compact('materialsStud', 'topics', 'request', 'selectedTopicName'));
    }

      //material math
      public function materialMath(Request $request)
      {
          $topics = Topic::all();
          $selectedTopicId = $request->query('topic_id');
          $studentId = auth()->user()->stud_id; // assuming you're using Laravel's built-in auth system
      
          if ($selectedTopicId) {
              $selectedTopic = Topic::find($selectedTopicId);
              $selectedTopicName = $selectedTopic->name?? 'All Topics';
          } else {
              $selectedTopicName = 'All Topics';
          }
      
          //  show materials they are assigned to by retrieve the materials using student_id in material_student database.
          $materialsStud = Material::whereHas('students', function ($query) use ($studentId, $selectedTopicId) {
              $query->where('material_student.student_id', $studentId);
              if ($selectedTopicId) {
                  $query->where('materials.topic_id', $selectedTopicId);
              }
          })
          ->select('title', 'created_at', 'id')
          ->orderBy('created_at', 'desc')
          ->get();
      
          return view('classroom.stud_material_math', compact('materialsStud', 'topics', 'request', 'selectedTopicName'));
      }
    
    
      //material science
      public function materialSn(Request $request)
      {
          $topics = Topic::all();
          $selectedTopicId = $request->query('topic_id');
          $studentId = auth()->user()->stud_id; // assuming you're using Laravel's built-in auth system
      
          if ($selectedTopicId) {
              $selectedTopic = Topic::find($selectedTopicId);
              $selectedTopicName = $selectedTopic->name?? 'All Topics';
          } else {
              $selectedTopicName = 'All Topics';
          }
      
          //  show materials they are assigned to by retrieve the materials using student_id in material_student database.
          $materialsStud = Material::whereHas('students', function ($query) use ($studentId, $selectedTopicId) {
              $query->where('material_student.student_id', $studentId);
              if ($selectedTopicId) {
                  $query->where('materials.topic_id', $selectedTopicId);
              }
          })
          ->select('title', 'created_at', 'id')
          ->orderBy('created_at', 'desc')
          ->get();
      
          return view('classroom.stud_material_sn', compact('materialsStud', 'topics', 'request', 'selectedTopicName'));
      }


          //material science
          public function materialHtr(Request $request)
          {
              $topics = Topic::all();
              $selectedTopicId = $request->query('topic_id');
              $studentId = auth()->user()->stud_id; // assuming you're using Laravel's built-in auth system
          
              if ($selectedTopicId) {
                  $selectedTopic = Topic::find($selectedTopicId);
                  $selectedTopicName = $selectedTopic->name?? 'All Topics';
              } else {
                  $selectedTopicName = 'All Topics';
              }
          
              //  show materials they are assigned to by retrieve the materials using student_id in material_student database.
              $materialsStud = Material::whereHas('students', function ($query) use ($studentId, $selectedTopicId) {
                  $query->where('material_student.student_id', $studentId);
                  if ($selectedTopicId) {
                      $query->where('materials.topic_id', $selectedTopicId);
                  }
              })
              ->select('title', 'created_at', 'id')
              ->orderBy('created_at', 'desc')
              ->get();
          
              return view('classroom.stud_material_htr', compact('materialsStud', 'topics', 'request', 'selectedTopicName'));
          }
        
    

     //View for Student
public function viewMaterialS($id)
{
    $material = Material::findOrFail($id);

    return view('classroom.material_Student_View', compact('material'));
}

//task eng
public function task(Request $request)
{
    $topics = TopicTask::all();
    $selectedTopicId = $request->query('topic_id');
    $studentId = auth()->user()->stud_id; // assuming you're using Laravel's built-in auth system

    if ($selectedTopicId) {
        $selectedTopic = TopicTask::find($selectedTopicId);
        $selectedTopicName = $selectedTopic->name ?? 'All Topics';
    } else {
        $selectedTopicName = 'All Topics';
    }

    // Retrieve the tasks assigned to the student
    $taskStud = Task::whereHas('students', function ($query) use ($studentId, $selectedTopicId) {
        $query->where('student_id', $studentId);
        if ($selectedTopicId) {
            $query->where('tasks.topic_id', $selectedTopicId);
        }
    })
    ->select('title', 'created_at', 'id')
    ->orderBy('created_at', 'desc')
    ->get();

    return view('classroom.stud_task', compact('taskStud', 'topics', 'request', 'selectedTopicName'));
}

//task math
public function taskMath(Request $request)
{
    $topics = TopicTask::all();
    $selectedTopicId = $request->query('topic_id');
    $studentId = auth()->user()->stud_id; // assuming you're using Laravel's built-in auth system

    if ($selectedTopicId) {
        $selectedTopic = TopicTask::find($selectedTopicId);
        $selectedTopicName = $selectedTopic->name ?? 'All Topics';
    } else {
        $selectedTopicName = 'All Topics';
    }

    // Retrieve the tasks assigned to the student
    $taskStud = Task::whereHas('students', function ($query) use ($studentId, $selectedTopicId) {
        $query->where('student_id', $studentId);
        if ($selectedTopicId) {
            $query->where('tasks.topic_id', $selectedTopicId);
        }
    })
    ->select('title', 'created_at', 'id')
    ->orderBy('created_at', 'desc')
    ->get();

    return view('classroom.stud_task_math', compact('taskStud', 'topics', 'request', 'selectedTopicName'));
}

//task science
public function taskSn(Request $request)
{
    $topics = TopicTask::all();
    $selectedTopicId = $request->query('topic_id');
    $studentId = auth()->user()->stud_id; // assuming you're using Laravel's built-in auth system

    if ($selectedTopicId) {
        $selectedTopic = TopicTask::find($selectedTopicId);
        $selectedTopicName = $selectedTopic->name ?? 'All Topics';
    } else {
        $selectedTopicName = 'All Topics';
    }

    // Retrieve the tasks assigned to the student
    $taskStud = Task::whereHas('students', function ($query) use ($studentId, $selectedTopicId) {
        $query->where('student_id', $studentId);
        if ($selectedTopicId) {
            $query->where('tasks.topic_id', $selectedTopicId);
        }
    })
    ->select('title', 'created_at', 'id')
    ->orderBy('created_at', 'desc')
    ->get();

    return view('classroom.stud_task_sn', compact('taskStud', 'topics', 'request', 'selectedTopicName'));
}

//task history
public function taskHtr(Request $request)
{
    $topics = TopicTask::all();
    $selectedTopicId = $request->query('topic_id');
    $studentId = auth()->user()->stud_id; // assuming you're using Laravel's built-in auth system

    if ($selectedTopicId) {
        $selectedTopic = TopicTask::find($selectedTopicId);
        $selectedTopicName = $selectedTopic->name ?? 'All Topics';
    } else {
        $selectedTopicName = 'All Topics';
    }

    // Retrieve the tasks assigned to the student
    $taskStud = Task::whereHas('students', function ($query) use ($studentId, $selectedTopicId) {
        $query->where('student_id', $studentId);
        if ($selectedTopicId) {
            $query->where('tasks.topic_id', $selectedTopicId);
        }
    })
    ->select('title', 'created_at', 'id')
    ->orderBy('created_at', 'desc')
    ->get();

    return view('classroom.stud_task_htr', compact('taskStud', 'topics', 'request', 'selectedTopicName'));
}




       // View for Student
       public function viewTaskS($id)
       {
           $task = Task::findOrFail($id);
           $studentId = auth()->user()->stud_id;
           $taskStudent = task_student::where('task_id', $id)->where('student_id', $studentId)->first();
           $studentWorks = $taskStudent ? $taskStudent->studentWorks : [];
           $studentMarks = Grade::where('task_id', $id)->where('student_id', $studentId)->value('student_marks');
           $fullMarks = $task->marks;  // Assuming 'marks' is the column that stores the full marks for the task.
       
           return view('classroom.task_Student_View', compact('task', 'studentWorks', 'studentMarks', 'fullMarks'));
       }
       
       
       
       

       public function uploadStudentWork(Request $request)
       {
           $studentId = auth()->user()->stud_id;
       
           $request->validate([
               'task_id' => 'required|integer',
               'files.*' => 'required|file|mimes:pdf,doc,docx,txt',
           ]);
       
           $student = Student::find($studentId);
           if (!$student) {
               Toastr::error('Invalid student ID.', 'Error');
               return redirect()->back();
           }
       
           DB::beginTransaction();
       
           try {
               $taskStudent = task_student::firstOrCreate(
                   ['task_id' => $request->input('task_id'), 'student_id' => $studentId]
               );
       
               if ($request->hasFile('files')) {
                   foreach ($request->file('files') as $file) {
                       $filePath = $file->store('tasks_stud', 'public');
                       Log::info('File uploaded successfully', ['file_path' => $filePath]);
       
                       $studentWork = StudentWork::create([
                           'student_id' => $studentId,
                           'file_path' => $filePath,
                       ]);
                       Log::info('StudentWork created successfully', ['student_work_id' => $studentWork->id]);
       
                       $taskStudent->studentWorks()->attach($studentWork->id);
                       Log::info('TaskStudentWork entry created successfully', ['task_student_id' => $taskStudent->id, 'student_work_id' => $studentWork->id]);
                   }
       
                   DB::commit();
                   Toastr::success('Work submitted successfully.', 'Success');
                   return redirect()->back();
               }
           } catch (\Exception $e) {
               DB::rollBack();
               Log::error('Error submitting work', ['error' => $e->getMessage()]);
               Toastr::error('Failed to submit work. Please try again.', 'Error');
               return redirect()->back();
           }
       }
       
       
       public function deleteStudentWork($id)
       {
           // Find the student work record
           $studentWork = StudentWork::findOrFail($id);
       
           // Additional authorization check if needed (e.g., check if the student owns this work)
       
           // Delete the file from storage (assuming file_path points to the file location)
           if (Storage::exists($studentWork->file_path)) {
               Storage::delete($studentWork->file_path);
           }
       
           // Delete the database record
           $studentWork->delete();
       
           return redirect()->back()->with('success', 'File deleted successfully.');
       }
    


//---------------------------------------------------------------------------------------------------------------------------------------------------------

public function downloadMat($id)
{
    // Find the material by ID
    $material = Material::findOrFail($id);
  

    // Get the file path from the material
    $filePath = $material->file_path;
 


    // Check if the file exists in storage
    if (!Storage::disk('public')->exists($filePath)) {
        return redirect()->back()->with('error', 'File not found.');
    }

    // Download the file using Storage facade
    return Storage::disk('public')->download($filePath);
}

public function downloadTask($id)
{
    // Find the material by ID
    $task = Task::findOrFail($id);
  

    // Get the file path from the material
    $filePath = $task->file_path;
 


    // Check if the file exists in storage
    if (!Storage::disk('public')->exists($filePath)) {
        return redirect()->back()->with('error', 'File not found.');
    }

    // Download the file using Storage facade
    return Storage::disk('public')->download($filePath);
}

public function viewFile($id)
{
    // Find the material by ID
    $material = Material::findOrFail($id);
    $task = Task::findOrFail($id);
  

    // Get the file path from the material
    $filePath = $material->file_path;
    $filePath = $task->file_path;
  

    // Check if the file exists in storage
    if (!Storage::disk('public')->exists($filePath)) {
        return redirect()->back()->with('error', 'File not found.');
    }

    // Get the file's URL
    $fileUrl = Storage::disk('public')->url($filePath);

    // Return a view to display the file, or redirect to the file URL
return response()->file(storage_path('app/public/' . $filePath));
}
        


//-----------------------------------------------------------------------------------------------------------------------------------------------------------





}