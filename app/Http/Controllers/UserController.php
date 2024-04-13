<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Schedule;

class UserController extends Controller
{

    public function registrars() : array
    {
        return User::getUsers('Registrar');
    }
    public function professors() : array
    {
        return User::getUsers('Professor');
    }
    public function students() : array
    {
        return User::getUsers('Student');
    }


    public function account_store(Request $request)
    {
        User::storeUserEntry($request, $request->role);

        return json_encode(
            [
                'status'=> 'success',
                'message'=> 'Creating User Entry Done!',
                'code' => 200
            ]
        );
    }

    public function account_update(Request $request, User $user)
    {
        User::updateUserEntry($request, $request->role, $user);

        return json_encode(
            [
                'status'=> 'success',
                'message'=> 'Updating User Entry Done!',
                'code' => 200
            ]
        );
    }
    public function account_delete(Request $request, User $user)
    {
        $user->delete();

        return json_encode(
            [
                'status'=> 'success',
                'message'=> 'Deleting User Entry Done!',
                'code' => 200
            ]
        );
    }

    public function professor_schedule($id){
        return User::with("schedules")
        ->where([
            ["users.id", $id]
        ])
        ->first();
        
    }



    /**
     * Display a listing of the resource.
     *
     */
    public function index($role = null)
    {
    //    if( $role == "Professor" || $role == "Student"  ){
        return User::select(
                    "users.*",
                    "colleges.name as college_name",
                    "departments.name as department_name",
                    "departments.college_id",
                    )
                    ->leftJoin('departments', 'departments.id', 'users.department_id')
                    ->leftJoin('colleges', 'colleges.id', 'departments.college_id')
                    ->withTrashed()
                    ->get();

    //    }else{
    //     return User::withTrashed()->get();
    //    }
    }

    public function student_schedule($id){
        return User::with('subjects')->where([
            ["id", $id]
        ])->first();
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
