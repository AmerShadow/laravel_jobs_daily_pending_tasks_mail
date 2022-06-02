<?php

namespace App\Console\Commands;

use App\Mail\WelcomMail;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

use function PHPSTORM_META\map;

class DailyTasks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tasks:daily';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will send a user Task to him/her every day';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $pendingTasks=0;
        //$users=User::all();

        // foreach ($users as $key => $user) {
        //     $tasks=Task::where('user_id',$user->id)->get();
        //     Mail::to($user->email)->send(new WelcomMail($tasks));
        // }

        $tasks=Task::join('users','users.id','tasks.user_id')
                    ->select('users.id as user_id','users.name as user_name',
                            'users.email as user_email','tasks.id as task_id',
                            'tasks.date as due_date','tasks.title as title',
                            'tasks.description')
                    ->where('tasks.status',0)
                    ->whereDay('tasks.date',date('d'))
                    ->whereMonth('tasks.date',date('m'))
                    ->whereYear('tasks.date',date('Y'))
                    ->orderBy('user_id')
                    ->get();




        $users=$tasks->unique('user_id')->map->only('user_id','user_name','user_email');

        foreach ($users as $key => $user) {
            $userTasks=$tasks->where('user_id',$user['user_id'])->all();
            Mail::to($user['user_email'])->send(new WelcomMail($tasks));

            $this->info('Mails successfully sent to '.$user['user_email']." he/she has ".count($userTasks)." due tasks today");


        }



        // $tasks=Task::where('status',0)
        //             ->whereDay('date',date('d'))
        //             ->whereMonth('date',date('m'))
        //             ->whereYear('date',date('Y'))
        //             ->get();


        $this->info('Mails successfully sent to users');


        return 0;
    }
}
