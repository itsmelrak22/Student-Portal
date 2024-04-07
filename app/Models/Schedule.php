<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;


    public function students(){
        return $this->hasMany(StudentSchedule::class, 'schedule_id', 'id')
                            ->select(
                                'student_schedules.*',
                                'users.name as student_name',
                                'users.email',

                            )
                            ->join('users', 'users.id',  'student_schedules.student_id');
    }
}
