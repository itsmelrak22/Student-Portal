<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Department;
use App\Models\College;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function index(){
        $department = Department::select(
            'departments.*',
            'colleges.name as college_name'

        )
        ->leftJoin('colleges','colleges.id','departments.college_id')
        ->get();
        return $department;
    }

    public function insert(Request $request){
        // return $request;

        try {
            DB::beginTransaction();
            $department = new Department();
            $department->dept_code = $request->dept_code;
            $department->college_id = $request->college_id;
            $department->name = $request->name;
            $department->save();

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

            $department = Department::find($request->id);
            $department->dept_code = $request->dept_code;
            $department->college_id = $request->college_id;
            $department->name = $request->name;
            $department->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function delete(Request $request){
        try {
            DB::beginTransaction();
            $department = Department::find($request->id);
            $department->delete();
            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
