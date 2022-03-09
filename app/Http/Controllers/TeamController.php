<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\AuthManager;

class TeamController extends Controller
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
        $teamid = Auth::user()->team_id;
        $teammembers = null;
        $teamdata = null;
        if ($teamid) {
            $teammembers = DB::table('users')
                ->where('team_id', $teamid)
                ->get();
            $teamdata = DB::table('teams')
                ->where('id', $teamid)
                ->get();
        }
        return view(
            'dashboard.teams.index',
            [
                'teamid' => $teamid,
                'teammembers' => $teammembers,
                'teamdata' => $teamdata,
            ]
        );
    }
    public function create()
    {
        return view('dashboard.teams.create');
    }

    public function createteam(Request $request)
    {
        $validated = $request->validate([
            'invitecode' => 'required',
            'name' => 'required',
        ]);
        $invitecode = $request->input('invitecode');
        $name = $request->input('name');

        if (Auth::user()->team_id) {
            return redirect()->back()->withErrors(['You are currently part of a team. You can\'t create a new one.']);
        }

        $checkinvite = DB::table('teams')
            ->where('externalid', $invitecode)
            ->get();

        if (count($checkinvite) !== 0) {
            return redirect()->back()->withErrors(['The entered invite code already exitst.']);
        }

        $data = DB::table('teams')
            ->insertGetId(
                ['externalid' => $invitecode, 'name' => $name]
            );

        $affected = DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['team_id' => $data]);

        return redirect()->route('teams.index');
    }


    public function join(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
        ]);
        $team = $request->input('id');

        $team = DB::table('teams')
            ->where('externalid', $team)
            ->get();
        if (count($team) !== 1) {
            return redirect()->back()->withErrors(['We couldn\'t find the team. Please enter a valid team code!']);
        }
        if (Auth::user()->team_id) {
            return redirect()->back()->withErrors(['You are currently part of a team. You can\'join a new one.']);
        } else {
            $affected = DB::table('users')
                ->where('id', Auth::user()->id)
                ->update(['team_id' => $team->first()->id]);
            return redirect()->back();
        }
    }

    public function leave(Request $request)
    {
        $affected = DB::table('users')
            ->where('id', Auth::user()->id)
            ->update(['team_id' => null]);
        return redirect()->route('teams.index');
    }
}
