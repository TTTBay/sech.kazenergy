<?php


namespace App\Http\Controllers;


use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{

    public function index()
    {
        $contests = DB::table('contests')->get();
        return view('home',['contests'=>$contests]);
    }

    public function changeLocale($locale)
    {
        session(['locale'=>$locale]);
        App::setLocale($locale);
        return redirect()->back();
    }

}
