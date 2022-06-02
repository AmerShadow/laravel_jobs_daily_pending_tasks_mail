<?php

namespace App\Http\Controllers;

use App\Mail\WelcomMail;
use App\Models\Employee;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Mail;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function show(Employee $employee)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function edit(Employee $employee)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Employee $employee)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Employee $employee)
    {
        //
    }


    public function sendMAil()
    {
        //return Carbon::today();
        //$date=date();
        return $tasks=Task::join('users','users.id','tasks.user_id')
                    ->select('users.id as user_id','tasks.id as task_id',
                            'tasks.date as due_date','tasks.title as title',
                            'tasks.description')
                    //  ->where('users.id','tasks.user_id')
                    ->whereDay('tasks.date',date('d'))
                    ->whereMonth('tasks.date',date('m'))
                    ->whereYear('tasks.date',date('Y'))
                    ->orderBy('user_id')
                    ->get();

       // Mail::to('amersohel4all@gmail.com')->send(new WelcomMail);

       //return $maxTaskUser=Task::where('user_id',101)->get();
       $user=User::where('id','!=',1)->get();

       //$user->email="amersohel4all@gmail.com";
        foreach ($user as $key => $u) {
            $u->delete();
        }
       //$user->update();
       return Task::all();
       return response()->json($tasks);
    }
}
