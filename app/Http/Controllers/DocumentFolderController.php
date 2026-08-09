<?php

namespace App\Http\Controllers;

use App\Models\DocumentFolder;
use Illuminate\Http\Request;

class DocumentFolderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:document_folders,name',
            'description' => 'nullable|string',
        ]);

        DocumentFolder::create([
            'name' => $request->name,
            'description' => $request->description,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Folder created successfully.');
    }

    public function update(Request $request, $slug)
    {
        $folder = DocumentFolder::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255|unique:document_folders,name,' . $folder->id,
            'description' => 'nullable|string',
        ]);

        $folder->update($request->only(['name', 'description']));

        return redirect()->route('admin.documents.index')->with('success', 'Folder updated successfully.');
    }

    public function destroy($slug)
    {
        $folder = DocumentFolder::where('slug', $slug)->first();

        if (!$folder) {
            return redirect()->back()->with('error', 'Folder not found.');
        }

        // Documents inside are kept and become uncategorized (folder_id nulls out via FK).
        $folder->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Folder deleted. Its documents were moved to Uncategorized.');
    }
}
