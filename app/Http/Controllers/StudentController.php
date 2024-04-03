<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use Illuminate\Support\Facades\DB;

class StudentController extends Controller
{
    public function index(){
        return Student::all();
    }

    public function insert(Request $request){
        // return $request;

        try {
            DB::beginTransaction();

            $student = new Student;
            $student->name = $request->name;
            $student->save();

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

            $student = Student::find($request->id);
            $student->name = $request->name;
            $student->save();

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

            $student = Student::find($request->id);
            $student->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            $e->getMessage();
        }
    }
}
