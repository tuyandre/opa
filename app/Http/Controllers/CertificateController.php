<?php

namespace App\Http\Controllers;

use App\Models\RegistrationStudent;
use App\Models\StudentMaterial;
use App\Models\TrainingSession;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CertificateController extends Controller
{
    public function index()
    {
        $student = auth()->user()->student;
        $certificates = $student ? $student->certificates()->with('session')->get() : collect();
        $materials = $student ? $student->materials()->where('type', 'material')->with('session')->get() : collect();
        return view('backend.students.certificates', compact('certificates', 'materials'));
    }
    public function certificates()
    {
        $certificates = StudentMaterial::with(['student', 'session'])->certificates()->where('status', 'Active')->get();
        return view('backend.materials.certificates', compact('certificates'));
    }

    //store certificate (manual upload of a pre-made PDF)
    public function storeCertificate(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'student_id' => 'required|exists:registration_students,id',
            'file' => 'required|mimes:pdf'
        ]);

        $student = RegistrationStudent::with('session')->find($request->student_id);
        if (!$student->session || !$student->session->isCompleted()) {
            return redirect()->back()->with('error', 'Certificate can only be issued once the training session is marked Completed.');
        }

        $file = $request->file('file');
        $file_name = time() . '_'.$file->getClientOriginalName(). '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/certificates'), $file_name);

        $certificate = new StudentMaterial();
        $certificate->title = $request->title;
        $certificate->description = $request->description;
        $certificate->status = 'Active';
        $certificate->type = 'certificate';
        $certificate->training_session_id = $student->training_session_id;
        $certificate->file = $file_name;
        $certificate->student_id = $request->student_id;
        $certificate->save();
        return redirect()->back()->with('success', 'Certificate added successfully');
    }

    //auto-generate certificates for many students in a completed session at once
    public function generateBulk(Request $request)
    {
        $request->validate([
            'training_session_id' => 'required|exists:training_sessions,id',
            'student_ids' => 'required|array|min:1',
            'student_ids.*' => 'exists:registration_students,id',
        ]);

        $session = TrainingSession::find($request->training_session_id);
        if (!$session->isCompleted()) {
            return redirect()->back()->with('error', 'Certificates can only be generated once the session is marked Completed.');
        }

        $generated = 0;
        $skipped = 0;

        $certificatesPath = public_path('uploads/certificates');
        if (!is_dir($certificatesPath)) {
            mkdir($certificatesPath, 0755, true);
        }

        foreach ($request->student_ids as $studentId) {
            $student = RegistrationStudent::find($studentId);
            if (!$student || (int) $student->training_session_id !== (int) $session->id) {
                continue;
            }

            $alreadyIssued = StudentMaterial::where('student_id', $student->id)->where('type', 'certificate')->exists();
            if ($alreadyIssued) {
                $skipped++;
                continue;
            }

            $pdf = Pdf::loadView('pdf.certificate', [
                'student_name' => $student->full_name,
                'session_title' => $session->session_title,
                'session_code' => $session->code,
                'session_duration' => $session->duration,
                'issue_date' => now()->format('F j, Y'),
            ])->setPaper('a4', 'landscape');

            $file_name = time() . '_' . Str::slug($student->full_name) . '-certificate.pdf';
            $pdf->save(public_path('uploads/certificates/' . $file_name));

            $certificate = new StudentMaterial();
            $certificate->title = 'Certificate of Completion';
            $certificate->description = $session->session_title . ' (' . $session->code . ')';
            $certificate->status = 'Active';
            $certificate->type = 'certificate';
            $certificate->training_session_id = $session->id;
            $certificate->file = $file_name;
            $certificate->student_id = $student->id;
            $certificate->save();
            $generated++;
        }

        $message = "$generated certificate(s) generated.";
        if ($skipped > 0) {
            $message .= " $skipped student(s) already had a certificate and were skipped.";
        }

        return redirect()->back()->with('success', $message);
    }

    //store a session material for a student
    public function storeMaterial(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'student_id' => 'required|exists:registration_students,id',
            'file' => 'required|mimes:pdf,doc,docx,png,jpg,jpeg,mp4,mov,avi,wmv,webm,mkv|max:204800'
        ]);

        $student = RegistrationStudent::find($request->student_id);

        $file = $request->file('file');
        $file_name = time() . '_'.$file->getClientOriginalName(). '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/student-materials'), $file_name);

        $material = new StudentMaterial();
        $material->title = $request->title;
        $material->description = $request->description;
        $material->status = 'Active';
        $material->type = 'material';
        $material->training_session_id = $student->training_session_id;
        $material->file = $file_name;
        $material->student_id = $request->student_id;
        $material->save();
        return redirect()->back()->with('success', 'Material added successfully');
    }

    //delete a student material or certificate
    public function destroy($id)
    {
        $certificate = StudentMaterial::find($id);
        if (!$certificate) {
            return redirect()->back()->with('error', 'Item not found');
        }
        $folder = $certificate->type === 'material' ? 'uploads/student-materials/' : 'uploads/certificates/';
        if (file_exists(public_path($folder.$certificate->file))){
            unlink(public_path($folder.$certificate->file));
        }
        $certificate->delete();
        return redirect()->back()->with('success', 'Deleted successfully');
    }
}
