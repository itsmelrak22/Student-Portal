<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Event;
use Illuminate\Support\Facades\DB;

class EventController extends Controller
{
    public function index()
    {
        return Event::all();
    }

    public function insert(Request $request)
    {
        // return $request;
        try {
            DB::beginTransaction();
            
            $event = new Event();
            $event->title = $request->title;
            $event->image = $request->image;
            $event->content = $request->content;
            $event->save();


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
            
            $event = Event::find($request->id);
            $event->title = $request->title;
            $event->image = $request->image;
            $event->content = $request->content;
            $event->save();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }

    public function delete(Request $request){
        try {
            DB::beginTransaction();

            $event = Event::find($request->id);
            $event->delete();

            DB::commit();
        } catch (\Throwable $e) {
            DB::rollBack();
            return $e->getMessage();
        }
    }
}
