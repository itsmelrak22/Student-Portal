<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Professor;
use Illuminate\Support\Facades\DB;

class ProfessorController extends Controller
{
    public function index(){
        return Professor::all();
    }

    public function insert(Request $request){
        // return $request;

        try {
            DB::beginTransaction();

            $professor = new Professor;
            $professor->name = $request->name;
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
