<?php

namespace App\Http\Controllers;

use App\Models\ClientDocument;
use App\Models\CompanyDocument;
use App\Models\StudentMaterial;
use App\Models\TrainingMaterial;

class DownloadController extends Controller
{
    public function downloadClientDocument($slug)
    {
        $document = ClientDocument::where('slug', $slug)->firstOrFail();

        $filePath = public_path('uploads/clients/' . $document->file);
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        $extension = pathinfo($document->file, PATHINFO_EXTENSION);
        return response()->download($filePath, $document->title . '.' . $extension);
    }

    // Client documents/contracts can always be viewed in-browser by anyone who can
    // see the client (view-client-documents); actually saving the file to disk is a
    // separate, more sensitive permission (download-client-documents).
    public function viewClientDocument($slug)
    {
        $document = ClientDocument::where('slug', $slug)->firstOrFail();

        return view('materials.viewer', [
            'title' => $document->title,
            'rawUrl' => route('admin.clients.documents.raw', $document->slug),
            'category' => $this->mimeCategory($document->file),
            'backUrl' => url()->previous(route('admin.clients.index')),
        ]);
    }

    public function rawClientDocument($slug)
    {
        $document = ClientDocument::where('slug', $slug)->firstOrFail();

        $filePath = public_path('uploads/clients/' . $document->file);
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->file($filePath);
    }

    public function downloadCompanyDocument($slug)
    {
        $document = CompanyDocument::where('slug', $slug)->firstOrFail();

        $filePath = public_path('uploads/documents/' . $document->file);
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        $extension = pathinfo($document->file, PATHINFO_EXTENSION);
        return response()->download($filePath, $document->title . '.' . $extension);
    }

    public function viewCompanyDocument($slug)
    {
        $document = CompanyDocument::where('slug', $slug)->firstOrFail();

        return view('materials.viewer', [
            'title' => $document->title,
            'rawUrl' => route('admin.documents.raw', $document->slug),
            'category' => $this->mimeCategory($document->file),
            'backUrl' => url()->previous(route('admin.documents.index')),
        ]);
    }

    public function rawCompanyDocument($slug)
    {
        $document = CompanyDocument::where('slug', $slug)->firstOrFail();

        $filePath = public_path('uploads/documents/' . $document->file);
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->file($filePath);
    }

    public function downloadCertificate($slug)
    {
        $certificate = StudentMaterial::where('type', 'certificate')->where('slug', $slug)->firstOrFail();
        $this->authorizeStudentMaterialAccess($certificate);

        $filePath = public_path('uploads/certificates/' . $certificate->file);
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        $extension = pathinfo($certificate->file, PATHINFO_EXTENSION);
        return response()->download($filePath, $certificate->title . '.' . $extension);
    }

    // Wrapper page: embeds the PDF/video with the browser's own download/print
    // controls suppressed, instead of navigating straight to the raw file.
    public function viewCertificate($slug)
    {
        $certificate = StudentMaterial::where('type', 'certificate')->where('slug', $slug)->firstOrFail();
        $this->authorizeStudentMaterialAccess($certificate);

        return view('materials.viewer', [
            'title' => $certificate->title,
            'rawUrl' => route('student.certificates.raw', $certificate->slug),
            'category' => $this->mimeCategory($certificate->file),
            'backUrl' => url()->previous(route('home')),
        ]);
    }

    public function rawCertificate($slug)
    {
        $certificate = StudentMaterial::where('type', 'certificate')->where('slug', $slug)->firstOrFail();
        $this->authorizeStudentMaterialAccess($certificate);

        $filePath = public_path('uploads/certificates/' . $certificate->file);
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->file($filePath);
    }

    // Training materials are read/watched in-browser only, never downloaded as an attachment.
    public function viewMaterial($slug)
    {
        $material = TrainingMaterial::where('slug', $slug)->firstOrFail();

        return view('materials.viewer', [
            'title' => $material->title,
            'rawUrl' => route('student.training.materials.raw', $material->slug),
            'category' => $this->mimeCategory($material->file),
            'backUrl' => url()->previous(route('home')),
        ]);
    }

    public function rawMaterial($slug)
    {
        $material = TrainingMaterial::where('slug', $slug)->firstOrFail();

        $filePath = public_path('uploads/trainings/' . $material->file);
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        return response()->file($filePath);
    }

    // Session materials are viewed in-browser (streamed inline), never downloaded as an attachment.
    public function viewStudentMaterial($slug)
    {
        $material = StudentMaterial::where('type', 'material')->where('slug', $slug)->firstOrFail();
        $this->authorizeStudentMaterialAccess($material);

        return view('materials.viewer', [
            'title' => $material->title,
            'rawUrl' => route('student.student-materials.raw', $material->slug),
            'category' => $this->mimeCategory($material->file),
            'backUrl' => url()->previous(route('home')),
        ]);
    }

    public function rawStudentMaterial($slug)
    {
        $material = StudentMaterial::where('type', 'material')->where('slug', $slug)->firstOrFail();
        $this->authorizeStudentMaterialAccess($material);

        $filePath = public_path('uploads/student-materials/' . $material->file);
        if (!file_exists($filePath)) {
            abort(404, 'File not found');
        }

        // response()->file() serves inline (Content-Disposition: inline) and supports
        // HTTP Range requests, so PDFs render in the browser and videos can stream/seek
        // instead of being downloaded.
        return response()->file($filePath);
    }

    private function authorizeStudentMaterialAccess(StudentMaterial $item)
    {
        $user = auth()->user();
        if ($user->is_super_admin) {
            return;
        }
        if (!$user->student_id || (int) $item->student_id !== (int) $user->student_id) {
            abort(403, 'You do not have access to this file.');
        }
    }

    private function mimeCategory(string $filename): string
    {
        $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
        if ($extension === 'pdf') {
            return 'pdf';
        }
        if (in_array($extension, ['mp4', 'mov', 'avi', 'wmv', 'webm', 'mkv'])) {
            return 'video';
        }
        if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
            return 'image';
        }
        return 'other';
    }
}
