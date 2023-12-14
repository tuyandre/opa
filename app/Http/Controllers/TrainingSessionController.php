<?php

namespace App\Http\Controllers;

use App\Models\TrainingSession;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TrainingSessionController extends Controller
{
    //
    public function index()
    {
        $training_sessions = TrainingSession::all();
        return view('backend.settings.sessions.index', compact('training_sessions'));
    }

    //store training session
    public function store(Request $request)
    {
        $request->validate([
            'session_title' => 'required',
            'price' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'days' => 'required',
            'start_time' => 'required',
            'end_time' => 'required',

            'description' => 'required'
        ]);
        $randomString = Str::random(8);
        //count days between start date and end date
        $start_date = strtotime($request->start_date);
        $end_date = strtotime($request->end_date);
        $datediff = $end_date - $start_date;
        $days = round($datediff / (60 * 60 * 24));




        $training_session = new TrainingSession();
        $training_session->session_title = $request->session_title;
        $training_session->price = $request->price;
        $training_session->code = $randomString;
        $training_session->duration = $days.' days';
        $training_session->start_date = $request->start_date;
        $training_session->end_date = $request->end_date;
        $training_session->days = $request->days;
        $training_session->start_time = $request->start_time;
        $training_session->end_time = $request->end_time;
        $training_session->description = $request->description;
        $training_session->status = "Active";
        $training_session->save();
        return redirect()->back()->with('success', 'Training session added successfully.');
    }
    //delete training session
    public function destroy($id)
    {
        try {
            $training_session = TrainingSession::find($id);

            //check if session has students
            if($training_session->students->count() > 0){
                return redirect()->back()->with('error', 'Training session can not be deleted.Because it has students.');
            }else{
                $training_session->delete();
                return redirect()->back()->with('success', 'Training session deleted successfully.');
            }
        }catch (\Exception $exception) {
            return redirect()->back()->with('error', 'Training session can not be deleted.Because it has students.');
        }

    }
    //update status
    public function updateStatus($id, $status)
    {
        $training_session = TrainingSession::find($id);
        $training_session->status = $status;
        $training_session->save();
        return redirect()->back()->with('success', 'Training session status updated successfully.');
    }
    //get students by session id
    public function getStudentsBySessionId($id)
    {
        $training_session = TrainingSession::find($id);
        $students = $training_session->students;
        return view('backend.settings.sessions.session_students', compact('students', 'training_session'));
    }
}
