<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Course;

class CourseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Course::create([
            "department_id" => 4,
            "course_code" => "C-001",
            "course_name" => "Bachelor of Secondary Education",
        ]);
        Course::create([
            "department_id" => 3,
            "course_code" => "C-002",
            "course_name" => "BS Business Management",
        ]);
        Course::create([
            "department_id" => 1,
            "course_code" => "C-003",
            "course_name" => "BS Computer Science",
        ]);
        Course::create([
            "department_id" => 2,
            "course_code" => "C-004",
            "course_name" => "BS Criminology",
        ]);
        Course::create([
            "department_id" => 5,
            "course_code" => "C-005",
            "course_name" => "BS Hospitality Management",
        ]);
        Course::create([
            "department_id" => 1,
            "course_code" => "C-006",
            "course_name" => "BS Information Technology",
        ]);
        Course::create([
            "department_id" => 5,
            "course_code" => "C-007",
            "course_name" => "BS Psychology",
        ]);
    }
}
