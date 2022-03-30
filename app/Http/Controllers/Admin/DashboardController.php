<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index()
    {
        if(Auth::check()) return redirect()->route('admin.university');
    }
    // show dashboard college and university
    public function showDashboard(Request $request)
    {
        switch (last($request->segments())) {
            case 'university':
                $participants = DB::table('participants')
                    ->select('participants.id','participants.status','university_teams.name','participants.fullname')
                    ->leftJoin('university_teams','participants.team_id','=','university_teams.id')
                    ->where('participants.status','=','0')
                    ->where('participants.contest_id','=','1')
                    ->get();
                return view('admin.dashboard.university',['participants'=>$participants]);
            case 'college':
                $participants = DB::table('participants')
                    ->select('participants.id','participants.status','college_teams.name','participants.fullname')
                    ->leftJoin('college_teams','participants.team_id','=','college_teams.id')
                    ->where('participants.status','=','0')
                    ->where('participants.contest_id','=','2')
                    ->get();
                return view('admin.dashboard.college',['participants'=>$participants]);
            default:
                return abort(404);
        }
    }
}
