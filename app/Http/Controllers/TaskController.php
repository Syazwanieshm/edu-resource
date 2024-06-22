<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\ClassRoom;
use App\Models\TopicTask;
use App\Models\Student;

class TaskController extends Controller
{
    public function topic()
    {
        $topics = TopicTask::all();
        return view('classroom.tutor_task', compact('topics'));
    }

    public function storeTopic(Request $request)
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

    public function create()
    {
        $class = ClassRoom::all();
        $topics = TopicTask::all();

        return view('classroom.create_task', compact('class', 'topics'));
    }

    public function store(Request $request)
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

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('tasks', 'public');
                $task->file_path = $filePath;
            }

            $task->save();

            if ($request->filled('students')) {
                $task->students()->attach($request->students);
            } elseif ($request->has('selectAllStudents')) {
                $class = ClassRoom::findOrFail($request->class);
                $task->students()->attach($class->students->pluck('id'));
            }

            DB::commit();

            Toastr::success('Task created successfully!', 'Success');
            return redirect()->route('subclass_t/task/page');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();

            Toastr::error('Failed to create task :(' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
    }

    public function getStudents($classId)
    {
        $class = ClassRoom::with('students')->findOrFail($classId);
        return response()->json(['students' => $class->students]);
    }
}

