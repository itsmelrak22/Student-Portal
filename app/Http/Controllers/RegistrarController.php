<?php

namespace App\Http\Controllers;
use App\Models\Registrar;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class RegistrarController extends Controller
{
    public function index(){
        return Registrar::all();
    }

    public function insert(Request $request){
        // return $request;

        try {
            DB::beginTransaction();

            $registrar = new Registrar;
            $registrar->name = $request->name;
            $registrar->save();

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

            $registrar = Registrar::find($request->id);
            $registrar->name = $request->name;
            $registrar->save();

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

            $registrar = Registrar::find($request->id);
            $registrar->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();

            $e->getMessage();
        }
    }
}
