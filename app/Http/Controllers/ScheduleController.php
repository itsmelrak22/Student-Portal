<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Models\Professor;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedule = Schedule::select(
            'schedules.*',
            'professors.name as prof_name',
            'subjects.name as subject_name',
            'departments.id as department_id',
            'colleges.id as college_id',
        )
        ->leftJoin('professors', 'professors.id', 'schedules.professor_id')
        ->leftJoin('subjects', 'subjects.id', 'schedules.subject_id')
        ->leftJoin('departments', 'departments.id', 'subjects.department_id')
        ->leftJoin('colleges', 'colleges.id', 'departments.college_id')
        ->get();

        return $schedule;
    }

    public function insert(Request $request){
        // return $request;
        try {
            DB::beginTransaction();

            $schedule = new Schedule();
            $schedule->sched_code = $request->sched_code;
            $schedule->subject_id = $request->subject;
            $schedule->professor_id = $request->professor;
            $schedule->name = $request->name;
            $schedule->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            return $e->getMessage();
        }

    }

    public function update(Request $request){
        return $request;
    }

    
}
