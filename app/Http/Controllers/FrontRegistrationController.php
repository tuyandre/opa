<?php

namespace App\Http\Controllers;

use App\Models\RegistrationStudent;
use App\Models\StudentService;
use App\Models\TrainingService;
use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FrontRegistrationController extends Controller
{
    //get pricing page
    public function pricing()
    {
        //select all training sessions
        $training_sessions = TrainingSession::where('status', 'Active')->get();
        //all services
        $services = TrainingService::where('is_active', true)->get();
        //return view
        return view('pricing', compact('training_sessions', 'services'));
    }

    //get register page
    public function registration_training($session_id)
    {
        $session=TrainingSession::find($session_id);
        $services = TrainingService::where('is_active', true)->get();
        return view('training', compact('session', 'services'));
    }

    //store registration form data
    public function storeRegistration(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:training_sessions,id',
            'name' => 'required',
            'email' => 'required',
            'telephone' => 'required',
            'comment' => 'required'
        ]);
        $registration = new RegistrationStudent();
        $registration->training_session_id = $request->session_id;
        $registration->full_name = $request->name;
        $registration->email = $request->email;
        $registration->telephone = $request->telephone;
        $registration->company_tin = $request->company_tin;
        $registration->company_name = $request->company_name;
        $registration->payment_agreement = $request->agreement?true:false;
        $registration->comment = $request->comment;
        $registration->save();
        //store services
        //multiple services
        $services = $request->services;
        foreach ($services as $service) {
            $service_student = new StudentService();
            $service_student->registration_student_id = $registration->id;
            $service_student->training_session_id = $request->session_id;
            $service_student->training_service_id = $service;
            $service_student->save();
        }
        return redirect()->back()->with('success', 'Registration submitted successfully. We will contact you soon.');
    }
}
