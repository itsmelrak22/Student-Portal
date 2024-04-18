<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Course;

class CourseController extends Controller
{

    public function index(){
        return Course::getAllCourse();
    }

    public function store(Request $request){
        Course::storeData($request);
    }
    public function update(Request $request, Course $course){
        Course::updateData($request, $course);
    }

    public function delete( Course $course){
        Course::deleteData($course);
    }
}
