<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Subject;
use Illuminate\Support\Facades\DB;

class SubjectController extends Controller
{
    public function index(){
        return Subject::all();
    }

    public function insert(Request $request){
        // return $request;

        try {
            DB::beginTransaction();

            $subject = new Subject;
            $subject->name = $request->name;
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
