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
        // Anyone who isn't an actual student (super admins and staff accounts
        // alike) lands on the dashboard; only real students get redirected.
        if (is_null(auth()->user()->student_id)){
            return view('home');
        }else{
            return redirect()->route('student.training.materials.index');
        }
    }
}
