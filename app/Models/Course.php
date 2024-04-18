<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Course extends Model
{
    use HasFactory, SoftDeletes;

    public static function getAllCourse(){
        $data = new self;
        $_courses = $data->select('courses.*', 'departments.name as department_name')
                        ->leftJoin('departments', 'courses.department_id', 'departments.id')
                        ->get();

        return $_courses;
    }

    public static function storeData($request){
        $course = new self;
        $course->course_code = $request->course_code;
        $course->course_name = $request->course_name;
        $course->department_id = $request->department_id;
        $course->created_at = new \Datetime;
        $course->updated_at = new \Datetime;
        $course->save();
    }
    public static function updateData($request, $course){
        $course->course_code = $request->course_code;
        $course->course_name = $request->course_name;
        $course->department_id = $request->department_id;
        $course->updated_at = new \Datetime;
        $course->save();
    }
    public static function deleteData( $course){
        $course->delete();
    }
}
