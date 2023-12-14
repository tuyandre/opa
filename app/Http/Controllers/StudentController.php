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

    //delete student
    public function destroy($id)
    {
        try {
            $student = RegistrationStudent::find($id);
            $student->delete();
            return redirect()->back()->with('success', 'Student deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }
    //change payment status
    public function changePaymentStatus($id)
    {
        try {
            $student = RegistrationStudent::find($id);
            $student->is_paid = true;
            $student->status = 'Active';
            $student->save();
            return redirect()->back()->with('success', 'Payment status changed successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }
    //reply to student
    public function replyToStudent(Request $request)
    {
        try {
            $student = RegistrationStudent::find($request->student_id);
            $student->reply_status = true;
            $student->reply_message = $request->reply_message;
            $student->status = $request->status;
            $student->save();
            return redirect()->back()->with('success', 'Reply sent successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Something went wrong, please try again.');
        }
    }
}
