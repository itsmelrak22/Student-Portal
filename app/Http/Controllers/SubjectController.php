<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index(){
        $subject = Subject::select(
            'subjects.*',
            'departments.name as dept_name'
        )
        ->leftJoin('departments','departments.id','subjects.department_id')
        ->get();

        return $subject;
    }

    public function insert(Request $request){
        // return $request;

        try {
            DB::beginTransaction();

            $subject = new Subject;
            $subject->name = $request->name;
            $subject->subject_code = $request->subject_code;
            $subject->department_id = $request->department_id;
            $subject->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }

    public function update(Request $request){
        // return $request;

        try {
            DB::beginTransaction();

            $subject = Subject::find($request->id);
            $subject->name = $request->name;
            $subject->subject_code = $request->subject_code;
            $subject->department_id = $request->dept_id;
            $subject->save();

            DB::commit();

        } catch (\Throwable $e) {
            DB::rollBack();

            return $e->getMessage();
        }
    }

    public function delete(Request $request){
        // return $request;

        try {
            DB::beginTransaction();

            $subject = Subject::find($request->id);
            $subject->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            $e->getMessage();
        }
    }
}
