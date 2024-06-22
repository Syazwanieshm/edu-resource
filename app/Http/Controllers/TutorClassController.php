<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Teacher;
use App\Models\Material;
use App\Models\Task;
use App\Models\ClassRoom;
use App\Models\Topic;
use App\Models\TopicTask;
use App\Models\Student;
use App\Models\Subject;
use App\Models\class_subject;
use App\Models\class_teacher;
use App\Models\task_student;
use App\Models\StudentWork;
use App\Models\TaskStudentWork;
use App\Models\Grade;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;



class TutorClassController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }




    
    public function index($id)
    {
        // Find the teacher by ID
        $teacher = Teacher::findOrFail($id);

        // Load the teacher's subjects with related class information
        $subjects = $teacher->subjects()->with('classrooms')->get();

        return view('classroom.subjectList_Teacher', compact('subjects'));
    }
    

    //MAIN IN TUTOR VIEW
    //public function main()
    //{
        // Fetch classrooms where the authenticated user is a teacher
       // $classSubjects = ClassRoom::whereHas('teachers', function ($query) {
               // $query->where('class_teacher.teacher_id', Auth::id());
            //})
            //->with('subjects')
            //->get();
    
       // return view('classroom.tutor_classroom', compact('classSubjects'));
   // }
    
    
    
    
    public function main()
    {
        
    
        return view('classroom.tutor_classroom');
    }
    
    

    //ANNOUNCEMENT IN TUTOR VIEW
    public function announcement()
    {
        return view('classroom.tutor_ann');
    }

    public function material(Request $request)
    {
        $topics = Topic::all();
        $selectedTopicId = $request->query('topic_id');
        $user = Auth::user();
    
        if ($selectedTopicId) {
            $selectedTopic = Topic::find($selectedTopicId);
            $selectedTopicName = $selectedTopic->name ?? 'All Topics';
        } else {
            $selectedTopicName = 'All Topics';
        }
    
        if ($user->role_name == 'Teachers') {
            // For teachers, only show materials they created
            $materialsTutor = Material::where('teacher_id', $user->id)
                ->when($selectedTopicId, function ($query) use ($selectedTopicId) {
                    return $query->where('topic_id', $selectedTopicId);
                })
                ->select('title', 'created_at', 'id')
                ->orderBy('created_at', 'desc')
                ->get();
        } elseif ($user->role_name == 'Student') {
            // For students, only show materials they are assigned to
            $materialsTutor = Material::whereHas('students', function ($query) use ($user) {
                    $query->where('students.id', $user->id);
                })
                ->when($selectedTopicId, function ($query) use ($selectedTopicId) {
                    return $query->where('topic_id', $selectedTopicId);
                })
                ->select('title', 'created_at', 'id')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            // If the user is neither a teacher nor a student, show no materials
            $materialsTutor = collect();
        }
    
        return view('classroom.tutor_material', compact('materialsTutor', 'topics', 'request', 'selectedTopicName'));
    }
    

public function viewMaterial($id)
{
    $material = Material::findOrFail($id);
    

    return view('classroom.material_Tutor_View', compact('material'));
}



//TASK IN TUTOR VIEW
       public function task(Request $request)
       {
           $topics = TopicTask::all();
           $selectedTopicId = $request->query('topic_id');
           $user = Auth::user();
       
           if ($selectedTopicId) {
               $selectedTopic = TopicTask::find($selectedTopicId);
               $selectedTopicName = $selectedTopic->name ?? 'All Topics';
           } else {
               $selectedTopicName = 'All Topics';
           }
       
           if ($user->role_name == 'Teachers') {
               // For teachers, only show tasks they created
               $taskTutor = Task::where('teacher_id', $user->id)
                   ->when($selectedTopicId, function ($query) use ($selectedTopicId) {
                       return $query->where('topic_id', $selectedTopicId);
                   })
                   ->select('title', 'created_at', 'id')
                   ->orderBy('created_at', 'desc')
                   ->get();


           } elseif ($user->role_name == 'Student') {
               // For students, only show tasks they are assigned to
               $taskTutor = Task::whereHas('students', function ($query) use ($user) {
                       $query->where('students.id', $user->id);
                   })
                   ->when($selectedTopicId, function ($query) use ($selectedTopicId) {
                       return $query->where('topic_id', $selectedTopicId);
                   })
                   ->select('title', 'created_at', 'id')
                   ->orderBy('created_at', 'desc')
                   ->get();
           } else {
               // If the user is neither a teacher nor a student, show no tasks
               $taskTutor = collect();
           }
       
           return view('classroom.tutor_task', compact('taskTutor', 'topics', 'request', 'selectedTopicName'));
       }

    
       
         //REVIEW IN TUTOR VIEW
         public function review()
         {
             return view('classroom.tutor_review');
         }


         //TUTOR MATERIAL MANAGEMENT
     

         public function topic()
    {
        $topics = Topic::all();
        return view('classroom.tutor_material', compact('topics'));
    }

    public function storeTopic(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            if (Topic::where('name', $request->name)->exists()) {
                Toastr::error('Topic with the provided name already exists :(', 'Error');
                return redirect()->back();
            }

            $topic = new Topic;
            $topic->name = $request->name;
            $topic->save();

            DB::commit();

            Toastr::success('Topic has been added successfully :)', 'Success');
            return redirect()->route('subclass_t/material/page');
        } catch (\Exception $e) {
            \Log::error($e);
            DB::rollback();

            Toastr::error('Failed to add a new topic :(' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    public function create()
    {
        $classes = ClassRoom::all();
        $subjects = Subject::all();
        $topics = Topic::all();

        return view('classroom.create_material', compact('classes', 'topics','subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt',
            'class' => 'required|exists:class,id', // Correct table name and primary key
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
            'topic' => 'nullable|exists:topic,id', // Correct table name and primary key
            'subject' => 'required|exists:subject,id', // Correct table name and primary key
        ]);
    
        try {
            DB::beginTransaction(); // Start the transaction
    
            // Log request data for debugging
            Log::info('Request data:', $request->all());
    
            // Handle file upload
            $material = new Material();
            $material->title = $request->title;
            $material->description = $request->description;
            $material->class_id = $request->class;
            $material->topic_id = $request->topic;
            $material->teacher_id = Auth::id();
            $material->sub_id = $request->subject;
    
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('materials', $filename, 'public');
                $material->file_path = $filePath;
    
                // Log file upload info
                Log::info('File uploaded:', ['filename' => $filename, 'filePath' => $filePath]);
            }
    
            // Debugging point
            Log::info('Material before save:', $material->toArray());
            // Uncomment the following line to stop the execution and dump the material object for inspection
            // dd($material);
    
            $material->save();
    
            // Attach students
            if ($request->filled('students')) {
                $material->students()->attach($request->students);
                Log::info('Students attached:', $request->students);
            } elseif ($request->has('selectAllStudents')) {
                $class = ClassRoom::findOrFail($request->class);
                $material->students()->attach($class->students->pluck('id')->toArray());
                Log::info('All students from class attached:', $class->students->pluck('id')->toArray());
            }
    
            DB::commit(); // Commit the transaction
    
            Toastr::success('Material created successfully!', 'Success');
            return redirect()->route('subclass_t/material/page');
    
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction in case of an exception
    
            Log::error('Failed to create material:', ['error' => $e->getMessage(), 'trace' => $e->getTraceAsString()]);
            Toastr::error('Failed to create material: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
    
    
    public function updateMaterial(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt',
            'class' => 'required|exists:class,id', // Correct table name and primary key
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
            'topic' => 'nullable|exists:topic,id', // Correct table name and primary key
            'subject' => 'required|exists:subject,id', // Correct table name and primary key
        ]);
    
        try {
            DB::beginTransaction(); // Start the transaction
    
            $material = Material::findOrFail($id);
            $material->title = $request->title;
            $material->description = $request->description;
            $material->class_id = $request->class;
            $material->topic_id = $request->topic;
            $material->sub_id = $request->subject;
    
            if ($request->hasFile('file')) {
                // Delete old file if exists
                if ($material->file_path) {
                    Storage::disk('public')->delete($material->file_path);
                }
                $file = $request->file('file');
                $filename = time() . '_' . $file->getClientOriginalName();
                $filePath = $file->storeAs('materials', $filename, 'public');
                $material->file_path = $filePath;
            }
    
            $material->save();
    
            // Sync students
            if ($request->filled('students')) {
                $material->students()->sync($request->students);
            } else {
                $material->students()->detach(); // Remove all students
            }
    
            DB::commit(); // Commit the transaction
    
            Toastr::success('Material updated successfully!', 'Success');
            return redirect()->route('subclass_t/material/page');
    
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction in case of an exception
    
            Log::error('Failed to update material: ' . $e->getMessage());
            Toastr::error('Failed to update material: ' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
    
    //EDIT MATERIAL 

    public function editMaterial($id)
    {
        $material = Material::findOrFail($id);
        $class = ClassRoom::all(); // Assuming you fetch all classes for dropdown
        $topics = Topic::all(); // Assuming you fetch all topics for dropdown
        $selectedStudents = $material->students->pluck('id')->toArray(); // Selected students for this material
        $students = Student::all(); // Fetch all students for the dropdown
        $subjects = Subject::all(); 
    
        return view('classroom.edit_materials', compact('material', 'class', 'topics', 'students', 'selectedStudents','subjects'));
    }
    
    
    
   

    public function destroyMaterial($id)
    {
        try {
            DB::beginTransaction(); // Start the transaction

            $material = Material::findOrFail($id);

            // Delete the file from storage
            if ($material->file_path) {
                Storage::disk('public')->delete($material->file_path);
            }

            // Detach associated students
            $material->students()->detach();

            // Delete the material
            $material->delete();

            DB::commit(); // Commit the transaction

            Toastr::success('Material deleted successfully!', 'Success');
            return redirect()->route('subclass_t/material/page');
        } catch (\Exception $e) {
            DB::rollback(); // Rollback the transaction in case of an exception

            Log::error('Failed to delete material: ' . $e->getMessage());
            Toastr::error('Failed to delete material :(' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }
    
//----------------------------------------------------------------------------------------------------------------------------------------------------------

    //TUTOR TASK MANAGEMENT

    public function topicTask()
    {
        $topics = TopicTask::all();
        return view('classroom.tutor_task', compact('topics'));
    }

    public function storeTopicTask(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        try {
            DB::beginTransaction();

            if (TopicTask::where('name', $request->name)->exists()) {
                Toastr::error('Topic with the provided name already exists :(', 'Error');
                return redirect()->back();
            }

            $topic = new TopicTask;
            $topic->name = $request->name;
            $topic->save();

            DB::commit();

            Toastr::success('Topic has been added successfully :)', 'Success');
            return redirect()->route('subclass_t/task/page');
        } catch (\Exception $e) {
            \Log::error($e);
            DB::rollback();

            Toastr::error('Failed to add a new topic :(' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    public function createTask()
    {
        $classes = ClassRoom::all();
        $topics = TopicTask::all();
        $subjects = Subject::all();

        return view('classroom.create_task', compact('classes', 'topics','subjects'));
    }

    public function storeTask(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date' => 'nullable|date',
        'marks' => 'nullable|string|max:255',
        'class' => 'required|exists:class,id', // Ensure correct table name and primary key
        'students' => 'nullable|array',
        'students.*' => 'exists:students,id',
        'topic' => 'nullable|exists:task_topic,id', // Ensure correct table name and primary key
        'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt',
        'subject' => 'required|exists:subject,id', // Correct table name and primary key
    ]);

    try {
        DB::beginTransaction();

        $task = new Task();
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->marks = $request->marks;
        $task->class_id = $request->class;
        $task->topic_id = $request->topic;
        $task->teacher_id = Auth::id();
        $task->sub_id = $request->subject;

        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('tasks', 'public');
            $task->file_path = $filePath;
        }

        $task->save();

        if ($request->filled('students')) {
            $task->students()->attach($request->students);
        } elseif ($request->has('selectAllStudents')) {
            $class = ClassRoom::findOrFail($request->class);
            $task->students()->attach($class->students->pluck('id')->toArray());
        }
        

        DB::commit();

        Toastr::success('Task created successfully!', 'Success');
        return redirect()->route('subclass_t/task/page');
    } catch (\Exception $e) {
        DB::rollback();
        Log::error('Failed to create task: ' . $e->getMessage());
        Toastr::error('Failed to create task: ' . $e->getMessage(), 'Error');
        return redirect()->back();
    }
}



    public function getTStudents($classId)
    {
        $class = ClassRoom::with('students')->findOrFail($classId);
        return response()->json(['students' => $class->students]);
    }

    //VIEW TASK


    public function viewTask($id)
{
    $task = Task::with(['students.works', 'students.grades'])->findOrFail($id);
    return view('classroom.task_Tutor_View', compact('task'));
}
    


//EDIT TASK

public function editTask($id)
{
    $task = Task::findOrFail($id);
    $class = ClassRoom::all(); // Assuming you fetch all classes for dropdown
    $topics = TopicTask::all(); // Assuming you fetch all topics for dropdown
    $selectedStudents = $task->students->pluck('id')->toArray(); // Selected students for this material
    $students = Student::all(); // Fetch all students for the dropdown
    $subjects = Subject::all(); 

    return view('classroom.edit_Task', compact('task', 'class', 'topics', 'students', 'selectedStudents','subjects'));
}




public function updateTask(Request $request, $id)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'due_date' => 'nullable|date',
        'marks' => 'nullable|string|max:255',
        'class' => 'required|exists:class,id',
        'students' => 'nullable|array',
        'students.*' => 'exists:students,id',
        'topic' => 'nullable|exists:task_topic,id',
        'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt',
        'subject' => 'required|exists:subject,id', // Correct table name and primary key
    ]);

    try {
        DB::beginTransaction(); // Start the transaction

        // Retrieve the existing task by its ID
        $task = Task::findOrFail($id);

        // Update the task attributes
        $task->title = $request->title;
        $task->description = $request->description;
        $task->due_date = $request->due_date;
        $task->marks = $request->marks;
        $task->class_id = $request->class;
        $task->topic_id = $request->topic;
        $task->sub_id = $request->subject;

        // Handle file upload if a new file is provided
        if ($request->hasFile('file')) {
            // Delete old file if it exists
            if ($task->file_path) {
                Storage::disk('public')->delete($task->file_path);
            }
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('tasks', $filename, 'public');
            $task->file_path = $filePath;
        }

        // Save the task
        $task->save();

        // Sync students
        if ($request->filled('students')) {
            $task->students()->sync($request->students);
        } else {
            $task->students()->detach(); // Remove all students if none are provided
        }

        DB::commit(); // Commit the transaction

        Toastr::success('Task updated successfully!', 'Success');
        return redirect()->route('subclass_t/task/page');

    } catch (\Exception $e) {
        DB::rollback(); // Rollback the transaction in case of an exception

        Log::error('Failed to update task: ' . $e->getMessage());
        Toastr::error('Failed to update task: ' . $e->getMessage(), 'Error');
        return redirect()->back();
    }
}


public function destroyTask($id)
{
    try {
        DB::beginTransaction(); // Start the transaction

        $task = Task::findOrFail($id);

        // Delete the file from storage
        if ($task->file_path) {
            Storage::disk('public')->delete($task->file_path);
        }

        // Detach associated students
        $task->students()->detach();

        // Delete the material
        $task->delete();

        DB::commit(); // Commit the transaction

        Toastr::success('Task deleted successfully!', 'Success');
        return redirect()->route('subclass_t/task/page');
    } catch (\Exception $e) {
        DB::rollback(); // Rollback the transaction in case of an exception

        Log::error('Failed to delete task: ' . $e->getMessage());
        Toastr::error('Failed to delete task :(' . $e->getMessage(), 'Error');
        return redirect()->back();
    }
}


//-----------------------------------------------------------------------------------------

    public function download($id)
    {
        // Find the material by ID
        $material = Material::findOrFail($id);
        $task= Task::findOrFail($id);
    
        // Get the file path from the material
        $filePath = $material->file_path;
        $filePath = $task->file_path;
    
        // Check if the file exists in storage
        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }
    
        // Download the file using Storage facade
        return Storage::disk('public')->download($filePath);
    }

    public function downloadTask($id)
    {
        $task = Task::findOrFail($id);
        $filePath = $task->file_path;

        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download($filePath);
    }

    //TEACHER DW STUDENT WORK
    public function downloadStudentFile($id)
    {
        $studentWork = StudentWork::findOrFail($id);
        $filePath = $studentWork->file_path;

        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        return Storage::disk('public')->download($filePath);
    }
    
    //teacher view student work
    public function viewStudentFile($id)
    {
        $studentWork = StudentWork::findOrFail($id);
        $filePath = $studentWork->file_path;

        if (!Storage::disk('public')->exists($filePath)) {
            return redirect()->back()->with('error', 'File not found.');
        }

        // Return a view to display the file, or redirect to the file URL
        return response()->file(storage_path('app/public/' . $filePath));
    }

 // Function to view task file
 public function viewTaskFile($id)
 {
     $task = Task::findOrFail($id);
     $filePath = $task->file_path;

     // Check if the file exists in storage
     if (!Storage::disk('public')->exists($filePath)) {
         return redirect()->back()->with('error', 'File not found.');
     }

     // Return the file for viewing or download
     return response()->file(storage_path('app/public/' . $filePath));
 }

 // Function to view material file
 public function viewMaterialFile($id)
 {
     $material = Material::findOrFail($id);
     $filePath = $material->file_path;

     // Check if the file exists in storage
     if (!Storage::disk('public')->exists($filePath)) {
         return redirect()->back()->with('error', 'File not found.');
     }

     // Return the file for viewing or download
     return response()->file(storage_path('app/public/' . $filePath));
 }

 public function storeGrade(Request $request, $taskId)
 {
     $request->validate([
         'student_id' => 'required|exists:students,id',
         'student_marks' => 'required|integer|min:0|max:100',
     ]);
 
     // Check if the task_id exists in the task_student_work table
     $taskExists = task_student::where('task_id', $taskId)->exists();
     if (!$taskExists) {
         Toastr::error('Invalid task ID.', 'Error');
         return redirect()->back();
     }
 
     try {
         DB::beginTransaction();
 
         $grade = Grade::updateOrCreate(
             [
                 'task_id' => $taskId,
                 'student_id' => $request->student_id
             ],
             [
                 'student_marks' => $request->student_marks,
                 'teacher_id' => auth()->user()->id // assuming the teacher is logged in
             ]
         );
 
         DB::commit();
 
         Toastr::success('Grade saved successfully!', 'Success');
         \Log::info('Grade saved successfully for task_id: '. $taskId. ', student_id: '. $request->student_id);
         return redirect()->back();
     } catch (\Exception $e) {
         \Log::error('Failed to save grade: '. $e->getMessage());
         DB::rollback();
 
         Toastr::error('Failed to save grade: '. $e->getMessage(), 'Error');
         return redirect()->back();
     }
 }
 

}
