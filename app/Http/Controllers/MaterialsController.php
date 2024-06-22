<?php

namespace App\Http\Controllers;

use DB;
use Log;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use App\Models\Material;
use App\Models\ClassRoom;
use App\Models\Topic;
use App\Models\Student;

use Illuminate\Support\Facades\Storage;

class MaterialsController extends Controller
{
    public function topic()
    {
        $topics = Topic::all();
        return view('classroom.tutor_material', compact('topics'));
    }

    public function create()
    {
        $class = ClassRoom::all();
        $topics = Topic::all();

        return view('classroom.create_material', compact('class', 'topics'));
    }

    public function index()
    {
        $materials = Material::select('title', 'created_at') // Selecting only title and created_at fields
                            ->orderBy('created_at', 'desc') // Order by created_at in descending order
                            ->get();

        return view('classroom.tutor_material', compact('materials'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,txt',
            'class' => 'required|exists:class,id',
            'students' => 'nullable|array',
            'students.*' => 'exists:students,id',
            'topic' => 'nullable|exists:topic,id',
        ]);

        try {
            DB::beginTransaction();

            $material = new Material();
            $material->title = $request->title;
            $material->description = $request->description;
            $material->class_id = $request->class;
            $material->topic_id = $request->topic;

            if ($request->hasFile('file')) {
                $filePath = $request->file('file')->store('materials', 'public');
                $material->file_path = $filePath;
            }

            $material->save();

            if ($request->filled('students')) {
                $material->students()->attach($request->students);
            } elseif ($request->has('selectAllStudents')) {
                $class = ClassRoom::findOrFail($request->class);
                $material->students()->attach($class->students->pluck('id'));
            }

            DB::commit();

            Toastr::success('Material created successfully!', 'Success');
            return redirect()->route('subclass_t/material/page');
        } catch (\Exception $e) {
            Log::error($e);
            DB::rollback();

            Toastr::error('Failed to create material :(' . $e->getMessage(), 'Error');
            return redirect()->back();
        }
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

    public function getStudents($classId)
    {
        $class = ClassRoom::with('students')->findOrFail($classId);
        return response()->json(['students' => $class->students]);
    }
}
