<?php

namespace App\Http\Controllers;

use App\Models\StudentSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StudentScheduleController extends Controller
{
    public function insert(Request $request){
        // return $request;

        try {
            DB::beginTransaction();

            $student_sched = new StudentSchedule();
            $student_sched->student_id = $request->student_id;
            $student_sched->schedule_id = $request->sched_id;
            $student_sched->save();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }
}
