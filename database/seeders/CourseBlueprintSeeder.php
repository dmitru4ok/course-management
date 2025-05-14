<?php

namespace Database\Seeders;

use App\Models\CourseBlueprint;
use Illuminate\Database\Seeder;

class CourseBlueprintSeeder extends Seeder
{
    public function run(): void
    {
        foreach (self::$courseNames as $course) {
            CourseBlueprint::create([
                'course_name' => fake()->unique()->randomElement(self::$courseNames),
                'credit_weight' => 5,
                'is_valid' => true,
                'faculty_code' => \App\Models\Faculty::inRandomOrder()->value('faculty_code')
            ]);
        }
    }

    private static $courseNames = [
    // Computer Science
    'Introduction to Computer Science',
    'Data Structures and Algorithms',
    'Operating Systems',
    'Databases',
    'Software Engineering',
    'Computer Networks',
    'Artificial Intelligence',
    'Web Development',
    'Mobile App Development',
    'Machine Learning',
    'Cybersecurity Fundamentals',
    'Mathematics for Computer Science',
    'Digital Logic Design',
    'Cloud Computing',
    'Programming Languages',
    'Computer Graphics',
    'Human-Computer Interaction',
    'Embedded Systems',
    'Parallel Computing',
    'Compiler Design',

    // Medicine
    'Anatomy and Physiology',
    'Human Genetics',
    'Pathophysiology',
    'Clinical Pharmacology',
    'Immunology and Microbiology',
    'Biochemistry',
    'Medical Terminology',
    'Diagnostic Imaging',
    'Medical Ethics and Law',
    'Public Health and Epidemiology',
    'Surgical Techniques',
    'Neuroscience',
    'Cardiology Fundamentals',
    'Internal Medicine',
    'Pediatrics',

    // Interdisciplinary / General University
    'Introduction to Psychology',
    'Statistics and Probability',
    'Research Methodology',
    'Professional Communication',
    'Ethics in Technology',
    'History of Science',
    'Academic Writing',
    'Philosophy of Mind',
    'Environmental Science',
    'Economics for Engineers'
];
}
