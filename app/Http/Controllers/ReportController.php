<?php

namespace App\Http\Controllers;

use Dompdf\Dompdf;

use App\Models\StudentDummy;
use App\Models\SubjectDummy;
use App\Models\CarryMarkDummy;
use Illuminate\Http\Request;
use PDF;
use Excel;
use App\Exports\StudentsExport;

class ReportController extends Controller
{
    public function index()
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
    
        return view('report.index', compact('classAverages', 'formAverages', 'subjectAverages'));
    }


    public function showPerformanceReport()
    {
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
    
        // Define the subjects
        $formCategories = ['Addmaths', 'Physics', 'Chemistry', 'Biology'];
    
        return view('report.performance_report', compact('formAverages', 'subjectAverages', 'formCategories'));
    }
    
    
    
    public function generatePdf(Request $request) {
        // Generate PDF logic here
        $dompdf = new Dompdf();
        $dompdf->loadHtml(view('pdf.report')->render());
        $dompdf->setPaper('A4', 'landscape');
        $dompdf->render();
        $dompdf->stream('report.pdf');
    }

    public function main()
    {
        // Logic for the main report view page
        return view('report.main');
    }

    public function taskReport()
    {
        // Logic for the task report view page
        return view('report.task');
    }

    public function generateStudentReport($studentId)
    {
        // Retrieve the student with their marks
        $student = Student::with('marks')->find($studentId);

        if (!$student) {
            return response()->json(['message' => 'No student found with ID ' . $studentId], 404);
        }

        $report = "Performance Report for " . $student->name . " (ID: " . $student->id . "):\n";
        $report .= str_repeat("-", 50) . "\n";

        $totalMarks = 0;
        $subjectCount = $student->marks->count();

        foreach ($student->marks as $mark) {
            $report .= $mark->subject . ": " . $mark->marks . "\n";
            $totalMarks += $mark->marks;
        }

        $averageMarks = $subjectCount ? $totalMarks / $subjectCount : 0;
        $report .= str_repeat("-", 50) . "\n";
        $report .= "Total Marks: " . $totalMarks . "\n";
        $report .= "Average Marks: " . number_format($averageMarks, 2) . "\n";

        return response()->json(['report' => $report], 200);
    }
}



