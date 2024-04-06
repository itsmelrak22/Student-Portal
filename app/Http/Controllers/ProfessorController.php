<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professor;
use App\Models\Department;
use Illuminate\Support\Facades\DB;

class ProfessorController extends Controller
{
    public function index(){
        $professor = Professor::select(
            'professors.*',
            'departments.name as dept_name'
        )
        ->leftJoin('departments', 'departments.id', 'professors.department_id')
        ->get();

        return $professor;
    }

    public function insert(Request $request){
        // return $request;

        try {
            DB::beginTransaction();

            $professor = new Professor;
            $professor->name = $request->name;
            $professor->prof_code = $request->prof_code;
            $professor->department_id = $request->department;
            $professor->email = $request->email;
            $professor->password = $request->password;
            $professor->save();

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

            $professor = Professor::find($request->id);
            $professor->name = $request->name;
            $professor->prof_code = $request->prof_code;
            $professor->department_id = $request->department;
            $professor->email = $request->email;
            $professor->password = $request->password;
            $professor->save();

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

            $professor = Professor::find($request->id);
            $professor->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            $e->getMessage();
        }
    }
}
