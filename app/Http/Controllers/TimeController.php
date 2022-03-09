<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Auth\AuthManager;

class TimeController extends Controller
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
        $data = DB::table('time')
            ->where('userid', Auth::user()->id)
            ->get();

        return view(
            'dashboard.time.index',
            [
                'data' => $data,
            ]
        );
    }

    public function edit(Request $request, $id)
    {
        $data = DB::table('time')
            ->where('userid', Auth::user()->id)
            ->where('id', $id)
            ->get();

        return view(
            'dashboard.time.edit',
            [
                'data' => $data,
            ]
        );
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'work' => 'required',
            'start' => 'required',
            'stop' => 'required',
        ]);

        $work = $request->input('work');
        $start = $request->input('start');
        $stop = $request->input('stop');

        $start = date('Y-m-d H:i:s', strtotime($start));
        $stop = date('Y-m-d H:i:s', strtotime($stop));

        DB::table('time')
            ->where('userid', Auth::user()->id)
            ->where('id', $id)
            ->update(['work' => $work, 'start' => $start, "stop" => $stop]);

        return redirect()->route('time.index');
    }

    public function insert(Request $request)
    {
        $validated = $request->validate([
            'work' => 'required',
            'start' => 'required',
            'stop' => 'required',
        ]);

        $work = $request->input('work');
        $start = $request->input('start');
        $stop = $request->input('stop');

        $start = date('Y-m-d H:i:s', strtotime($start));
        $stop = date('Y-m-d H:i:s', strtotime($stop));

        DB::table('time')
            ->insert(['work' => $work, 'start' => $start, "stop" => $stop, 'userid' => Auth::user()->id]);

        return redirect()->route('time.index');
    }

    public function create()
    {
        return view('dashboard.time.create');
    }
}
