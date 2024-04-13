<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\College;
class CollegeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $count = 10;

        for ($i=0; $i < $count ; $i++) { 

            $data = College::create([
                "college_code" => "TESTCOLLEGE-$i",
                "name" => "TEST COLLEGE $i",
            ]);

            

        }
    }
}
