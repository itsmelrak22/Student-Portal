<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'username',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getUsers($role){
        $users = new self;

        return $users->where([
            "role" => $role
        ])->get();
    }

    public static function storeUserEntry($data, $role){
        $user = new self;
        $user->name = $data["name"];
        $user->email = $data["email"];
        $user->username = $data["username"];
        $user->password = bcrypt('password');
        $user->role = $role;


        if($role == "Professor" || $role == "Student" || $role == "Adviser" ){
            $user->department_id = $data['department_id'];
        }

        $user->save();
    }
    public static function updateUserEntry($data, $role, $user){
        $user->name = $data["name"];
        $user->email = $data["email"];
        $user->role = $role;

        
        if($role == "Professor" || $role == "Student"){
            $user->department_id = $data['department_id'];
        }
        
        $user->save();
    }

    public function schedules()
    {
        return $this->hasMany(Schedule::class,'professor_id', 'id')
                            ->select('schedules.*', 'subjects.name AS subject_name')
                            ->leftJoin('subjects', 'subjects.id',  'schedules.subject_id');
    }
    public function subjects()
    {
        return $this->hasMany(StudentSchedule::class,'student_id', 'id')
                            ->select(
                                'student_schedules.*',
                                'schedules.name as schedule_name', 
                                'schedules.sched_code AS schedule_code',
                                'subjects.name AS subject_name',
                                'subjects.subject_code',
                                'users.name as prof_name',
                                'users.id as prof_id'
                            )
                            ->leftJoin('schedules', 'schedules.id',  'student_schedules.schedule_id')
                            ->leftJoin('subjects', 'subjects.id',  'schedules.subject_id')
                            ->leftJoin('users', 'users.id',  'schedules.professor_id');

    }

}
