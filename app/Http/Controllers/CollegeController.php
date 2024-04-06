<?php

namespace App\Http\Controllers;

use App\Models\College;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CollegeController extends Controller
{
    public function index()
    {
        return College::all();
    }

    public function insert(Request $request)
    {
        // return $request;
        try {
            DB::beginTransaction();
            
            $college = new College();
            $college->college_code = $request->college_code;
            $college->name = $request->name;
            $college->save();


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
            
            $college = College::find($request->id);
            $college->college_code = $request->college_code;
            $college->name = $request->name;
            $college->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function delete(Request $request){
        try {
            DB::beginTransaction();

            $college = College::find($request->id);
            $college->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    
}
