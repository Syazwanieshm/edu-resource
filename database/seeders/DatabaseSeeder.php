<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\StudentDummy;
use App\Models\SubjectDummy;
use App\Models\CarryMarkDummy;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        $classes = ['Brilliant', 'Creative', 'Effective', 'Innovative', 'Generous'];
        $forms = ['Form 1','Form 2', 'Form 3', 'Form 4', 'Form 5'];
        $subjects = ['English', 'Mathematics', 'Science', 'History', 'Geografi', 'Malay Language', 'Addmaths','Chemistry','Biology','Physics'];
        $restrictedSubjects = ['Addmaths', 'Biology', 'Chemistry', 'Physics'];

        // Seed Subjects
        foreach ($subjects as $subject) {
            SubjectDummy::create(['name' => $subject]);
        }

        // Fetch subject IDs
        $subjectIds = SubjectDummy::pluck('id', 'name');

        // Seed 500 Students and Carry Marks
        $totalStudents = 500;
        $studentCount = 0;
        $existingIds = [];

        foreach ($forms as $form) {
            foreach ($classes as $class) {
                for ($i = 0; $i < 20; $i++) {
                    if ($studentCount >= $totalStudents) break 2;

                    // Generate a unique student_id
                    do {
                        $studentId = strtoupper($form[0]). strtoupper($class[0]). Str::random(5);
                    } while (in_array($studentId, $existingIds) || StudentDummy::where('student_id', $studentId)->exists());

                    $existingIds[] = $studentId;

                    $student = StudentDummy::create([
                        'name' => $faker->name,
                        'student_id' => $studentId,
                        'form' => $form,
                        'class' => $class,
                    ]);

                    $carryMarkSubjects = $form == 'Form 4' || $form == 'Form 5'? $subjects : array_diff($subjects, $restrictedSubjects);

                    foreach ($carryMarkSubjects as $subject) {
                        CarryMarkDummy::create([
                            'student_id' => $student->id,
                            'subject_id' => $subjectIds[$subject],
                            'carry_mark' => $faker->numberBetween(0, 1000) / 100, // random carry mark between 0.00 and 10.00
                        ]);
                    }

                    $studentCount++;
                }
            }
        }
    }
}