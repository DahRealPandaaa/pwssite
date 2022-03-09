<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\AuthManager;

class DashboardController extends Controller
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
        if (!Auth::user()->team_id) {
            return redirect()->route('teams.index');
        }
        $teamid = Auth::user()->team_id;
        $teammembers = null;
        $teamdata = null;
        $teammembers = DB::table('users')
            ->where('team_id', $teamid)
            ->get();
        $teamdata = DB::table('teams')
            ->where('id', $teamid)
            ->get();
        $teamtodo = DB::table('todo')
            ->where('teamid', Auth::user()->team_id)
            ->whereIn('status', [0,1])
            ->get();
        $userids = array();
        $usertimes;
        foreach ($teammembers as $member) {
            array_push($userids, $member->id);
        }
        $timelist  = DB::table('time')
            ->whereIn('userid', $userids)
            ->get();


        return view('dashboard.index', [
            'teamid' => $teamid,
            'teammembers' => $teammembers,
            'teamdata' => $teamdata,
            'todo' => $teamtodo,
            'timelist' => $timelist,
        ]);
    }
}
