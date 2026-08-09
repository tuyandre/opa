<?php

namespace App\Http\Controllers;

use App\Models\CompanyDocument;
use App\Models\DocumentFolder;
use Illuminate\Http\Request;

class CompanyDocumentController extends Controller
{
    public function index()
    {
        $folders = DocumentFolder::withCount('documents')->orderBy('name')->get();
        $uncategorizedCount = CompanyDocument::whereNull('folder_id')->count();

        return view('backend.documents.index', compact('folders', 'uncategorizedCount'));
    }

    public function folder($slug)
    {
        $folder = DocumentFolder::where('slug', $slug)->firstOrFail();
        $documents = $folder->documents()->with('uploadedBy')->orderBy('title')->get();

        return view('backend.documents.folder', [
            'folder' => $folder,
            'documents' => $documents,
        ]);
    }

    public function uncategorized()
    {
        $documents = CompanyDocument::whereNull('folder_id')->with('uploadedBy')->orderBy('title')->get();

        return view('backend.documents.folder', [
            'folder' => null,
            'documents' => $documents,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'folder_slug' => 'nullable|string',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:20480',
        ]);

        $folder = $request->filled('folder_slug') ? DocumentFolder::where('slug', $request->folder_slug)->first() : null;

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/documents'), $fileName);

        CompanyDocument::create([
            'folder_id' => $folder?->id,
            'title' => $request->title,
            'description' => $request->description,
            'file' => $fileName,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->back()->with('success', 'Document uploaded successfully.');
    }

    public function destroy($id)
    {
        $document = CompanyDocument::find($id);

        if (!$document) {
            return redirect()->back()->with('error', 'Document not found.');
        }

        $filePath = public_path('uploads/documents/' . $document->file);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $document->delete();

        return redirect()->back()->with('success', 'Document deleted successfully.');
    }
}
