<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\AuthManager;

class ToDoController extends Controller
{
    /**
     * @var \Illuminate\Auth\SessionGuard
     */

    protected $sessionGuard;

    /**
     * AccountController constructor.
     *
     * @param \Illuminate\Auth\AuthManager                  $authManager
     * @param \Pterodactyl\Services\Users\UserUpdateService $updateService
     */

    /**
     * Create a new controller instance.
     *
     * @return void
     */

    public function __construct(AuthManager $authManager)
    {
        $this->sessionGuard = $authManager->guard();
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->team_id) {
            $data = DB::table('todo')
                ->where('teamid', Auth::user()->team_id)
                ->get();
            $teamusers = DB::table("users")
                ->where("team_id", Auth::user()->team_id)
                ->get();
            return view('dashboard.todo.index', 
            [
                "data" => $data,
                "teamusers" => $teamusers,
            ]
        );
        } else {
            return view('dashboard.todo.noteam');
        }
    }

    public function edit(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'progress' => 'required',
            'users' => 'required',
            'deadline' => 'required',
            'status' => 'required',           
            'work' => 'required',
        ]);

        $name = $request->input('name');
        $progress = $request->input('progress');
        $users = $request->input('users');
    
        $deadline = $request->input('deadline');
        $status = $request->input('status');
        $work = $request->input('work');
        $deadline = date('Y-m-d H:i:s', strtotime($deadline));

        DB::table('todo')
            ->where('teamid', Auth::user()->team_id)
            ->where('id', $id)
            ->update([
                "name" => $name,
                "progres" => $progress,
                "deadline" => $deadline,
                "assigneduserid" => $users,
                "status" => $status,
                "content" => $work
            ]);

        return redirect()->route('todo.index');
    }

    public function create(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required',
            'progress' => 'required',
            'users' => 'required',
            'deadline' => 'required',
            'status' => 'required',           
            'work' => 'required',
        ]);

        $name = $request->input('name');
        $progress = $request->input('progress');
        $users = $request->input('users');
    
        $deadline = $request->input('deadline');
        $status = $request->input('status');
        $work = $request->input('work');
        $deadline = date('Y-m-d H:i:s', strtotime($deadline));

        DB::table('todo')
            ->insert(['assigneduserid' => $users, 'status' => $status, "content" => $work, "name" => $name, "content" => $work, "progres" => $progress, "deadline" => $deadline, "teamid" => $id]);


        return redirect()->route('todo.index');
    }

}
