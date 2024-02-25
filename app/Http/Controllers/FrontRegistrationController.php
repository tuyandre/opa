<?php

namespace App\Http\Controllers;

use App\Models\RegistrationStudent;
use App\Models\Role;
use App\Models\StudentService;
use App\Models\TrainingService;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

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
    public function registration_training()
    {
        $services = TrainingService::where('is_active', true)->get();
        $sessions=TrainingSession::where('is_active',true)->get();
        return view('training', compact( 'services','sessions'));
    }

    //store registration form data
    public function storeRegistration(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:training_sessions,id',
            'name' => 'required',
            'email' => 'required|email|unique:registration_students,email',
            'telephone' => 'required',
            'comment' => 'required'
        ]);

        //chck if email exists
        $email = RegistrationStudent::where('email', $request->email)->first();
        if ($email) {
            return redirect()->back()->with('error', 'Email already exists');
        }


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
        if ($services) {
            foreach ($services as $service) {
                $service_student = new StudentService();
                $service_student->registration_student_id = $registration->id;
                $service_student->training_session_id = $request->session_id;
                $service_student->training_service_id = $service;
                $service_student->save();
            }
        }
        $randomString = Str::random(10);

        $role= Role::where('name','Student')->first();

        $user=new User();
        $user->name=$request->name;
        $user->email=$request->email;
        $user->password=bcrypt('password');
        $user->student_id=$registration->id;
        $user->role_id=$role->id;
        $user->save();



        //send email to admin and student
        $this->sendEmailToAdmin($registration);
        $this->sendEmailToStudent($registration);

        return redirect()->back()->with('success', 'Registration submitted successfully. We will contact you soon.');
    }

    //send email to admin
    public function sendEmailToAdmin($registration)
    {
        $details = array(
            'name' => $registration->full_name,
            'email' => $registration->email,
            'telephone' => $registration->telephone,
            'company_tin' => $registration->company_tin,
            'company_name' => $registration->company_name,
            'comment' => $registration->comment,
            'session' => $registration->session->session_title,
            'session_code' => $registration->session->code,
            'session_start_date' => $registration->session->start_date,
            'session_end_date' => $registration->session->end_date,
            'session_days' => $registration->session->days,
            'session_start_time' => $registration->session->start_time,
            'session_end_time' => $registration->session->end_time,
            'session_description' => $registration->session->description,
            'services' => $registration->services,
        );
        //get admin email
        $admin_data = DB::table('users')->where('is_super_admin', true)->first();


        //send email to admin
        try {
        \Mail::send('emails.admin_registration', $details, function ($message) use ($admin_data) {
            $message->to($admin_data->email, $admin_data->name)->subject('New Registration');
            $message->from('' . env('MAIL_FROM_ADDRESS') . '', env('MAIL_FROM_NAME'));
        });

        } catch (\Exception $e) {
            // Handle the error here
            \Log::error('Error sending email: ' . $e->getMessage());
            // You can add additional error handling logic as needed, such as logging the error or sending a notification
        }
}

//send email to student
public function sendEmailToStudent($registration)
{
    $details = array(
        'name' => $registration->full_name,
        'email' => $registration->email,
        'telephone' => $registration->telephone,
        'company_tin' => $registration->company_tin,
        'company_name' => $registration->company_name,
        'comment' => $registration->comment,
        'session' => $registration->session->session_title,
        'session_code' => $registration->session->code,
        'session_start_date' => $registration->session->start_date,
        'session_end_date' => $registration->session->end_date,
        'session_days' => $registration->session->days,
        'session_start_time' => $registration->session->start_time,
        'session_end_time' => $registration->session->end_time,
        'session_description' => $registration->session->description,
        'services' => $registration->services,
    );
    try{
    //send email to student
    \Mail::send('emails.student_registration', $details, function ($message) use ($registration) {
        $message->to($registration->email, $registration->full_name)->subject('Registration Confirmation');
        $message->from('' . env('MAIL_FROM_ADDRESS') . '', env('MAIL_FROM_NAME'));
    });

} catch (\Exception $e) {
    // Handle the error here
\Log::error('Error sending email: ' . $e->getMessage());
    // You can add additional error handling logic as needed, such as logging the error or sending a notification
}
}


    //services
    public function frontServices()
    {
        $services = TrainingService::where('is_active', true)->get();
        $sessions=TrainingSession::where('is_active',true)->get();
        return view('frontend.services', compact('services','sessions'));
    }

    public function frontAboutUs()
    {
        return view('frontend.about_us');
    }
    public function frontContactUs()
    {
        return view('frontend.contact');
    }
    public function trendingDetail()
    {
        return view('frontend.trending_detail');
    }


}
