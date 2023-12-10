<?php

namespace App\Http\Controllers;

use App\Models\RegistrationStudent;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function index()
    {
        $students = RegistrationStudent::with('session')->get();
        return view('backend.students.index', compact('students'));
    }
}
