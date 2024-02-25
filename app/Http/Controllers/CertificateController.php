<?php

namespace App\Http\Controllers;

use App\Models\StudentMaterial;
use Illuminate\Http\Request;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = StudentMaterial::where('student_id', auth()->user()->student_id)->get();
        return view('backend.students.certificates', compact('certificates'));
    }
    public function certificates()
    {
        $certificates = StudentMaterial::with('student')->where('status','Active')->get();
        return view('backend.materials.certificates', compact('certificates'));
    }

    //store certificate
    public function storeCertificate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'student_id' => 'required|exists:registration_students,id',
            'file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg'
        ]);

        $file = $request->file('file');
        $file_name = time() . '_'.$file->getClientOriginalName(). '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/certificates'), $file_name);

        $certificate = new StudentMaterial();
        $certificate->title = $request->title;
        $certificate->description = $request->description;
        $certificate->status = 'Active';
        $certificate->file = $file_name;
        $certificate->student_id = $request->student_id;
        $certificate->save();
        return redirect()->back()->with('success', 'Certificate added successfully');
    }

    //delete certificate
    public function destroy($id)
    {
        $certificate = StudentMaterial::find($id);
        if (!$certificate) {
            return redirect()->back()->with('error', 'Certificate not found');
        }
        //delete certificate file
        if (file_exists(public_path('uploads/certificates/'.$certificate->file))){
            unlink(public_path('uploads/certificates/'.$certificate->file));
        }
        $certificate->delete();
        return redirect()->back()->with('success', 'Certificate deleted successfully');
    }
}
