<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $totalTask = Task::count();
        $inProgressTask = Task::where('status', 'in_progress')->count();
        $completedTask = Task::where('status', 'done')->count();
        $latestTasks = Task::latest()->limit(5)->get();

        return view('home', compact('totalTask', 'inProgressTask', 'completedTask', 'latestTasks'));
    }
}
