<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Department::create([
            "dept_code" => "001",
            "name" => "Deparment of Computer Studies",
        ]);
        Department::create([
            "dept_code" => "002",
            "name" => "Department of Criminology",
        ]);
        Department::create([
            "dept_code" => "003",
            "name" => "Deparment of Business Management",
        ]);
        Department::create([
            "dept_code" => "004",
            "name" => "Department of Education",
        ]);
        Department::create([
            "dept_code" => "005",
            "name" => "Department of Hospitality Management",
        ]);
            
    }
}
