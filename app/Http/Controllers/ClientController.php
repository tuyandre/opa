<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientDocument;
use App\Models\User;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    public function index()
    {
        $clients = Client::with('assignedTo')->orderBy('name')->get();
        $staff = User::whereNull('student_id')->orderBy('name')->get();
        return view('backend.clients.index', compact('clients', 'staff'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'tax_number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'business_sector' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'assigned_to' => 'nullable|exists:users,id',
            'notes' => 'nullable|string',
        ]);

        $client = new Client([
            'name' => $request->name,
            'tax_number' => $request->tax_number,
            'email' => $request->email,
            'phone' => $request->phone,
            'address' => $request->address,
            'business_sector' => $request->business_sector,
            'assigned_to' => $request->assigned_to,
            'notes' => $request->notes,
            'created_by' => auth()->id(),
        ]);

        if ($request->hasFile('logo')) {
            $client->logo = $this->storeLogo($request->file('logo'));
        }

        $client->save();

        return redirect()->route('admin.clients.index')->with('success', 'Client added successfully.');
    }

    public function show($slug)
    {
        $client = Client::with(['assignedTo', 'documents.uploadedBy', 'systemAccounts.createdBy', 'contacts'])->where('slug', $slug)->firstOrFail();
        $staff = User::whereNull('student_id')->orderBy('name')->get();
        return view('backend.clients.show', compact('client', 'staff'));
    }

    public function update(Request $request, $slug)
    {
        $client = Client::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'tax_number' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string',
            'business_sector' => 'nullable|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required|string|in:Active,Inactive',
            'notes' => 'nullable|string',
        ]);

        $client->fill($request->only([
            'name', 'tax_number', 'email', 'phone',
            'address', 'business_sector', 'status', 'notes',
        ]));

        if ($request->hasFile('logo')) {
            if ($client->logo && file_exists(public_path('uploads/clients/logos/' . $client->logo))) {
                unlink(public_path('uploads/clients/logos/' . $client->logo));
            }
            $client->logo = $this->storeLogo($request->file('logo'));
        }

        $client->save();

        return redirect()->route('admin.clients.show', $client->slug)->with('success', 'Client updated successfully.');
    }

    private function storeLogo($file): string
    {
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/clients/logos'), $fileName);
        return $fileName;
    }

    public function assign(Request $request, $slug)
    {
        $client = Client::where('slug', $slug)->firstOrFail();

        $request->validate([
            'assigned_to' => 'nullable|exists:users,id',
        ]);

        $client->update(['assigned_to' => $request->assigned_to]);

        return redirect()->route('admin.clients.show', $client->slug)->with('success', 'Client assignment updated.');
    }

    public function destroy($slug)
    {
        $client = Client::where('slug', $slug)->first();

        if (!$client) {
            return redirect()->back()->with('error', 'Client not found.');
        }

        foreach ($client->documents as $document) {
            $filePath = public_path('uploads/clients/' . $document->file);
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }

        if ($client->logo && file_exists(public_path('uploads/clients/logos/' . $client->logo))) {
            unlink(public_path('uploads/clients/logos/' . $client->logo));
        }

        $client->delete();

        return redirect()->route('admin.clients.index')->with('success', 'Client deleted successfully.');
    }

    public function storeDocument(Request $request, $slug)
    {
        $client = Client::where('slug', $slug)->firstOrFail();

        $request->validate([
            'type' => 'required|in:document,contract',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file' => 'required|file|max:10240',
        ]);

        $file = $request->file('file');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move(public_path('uploads/clients'), $fileName);

        ClientDocument::create([
            'client_id' => $client->id,
            'type' => $request->type,
            'title' => $request->title,
            'description' => $request->description,
            'file' => $fileName,
            'uploaded_by' => auth()->id(),
        ]);

        return redirect()->route('admin.clients.show', $client->slug)->with('success', 'File uploaded successfully.');
    }

    public function destroyDocument($id)
    {
        $document = ClientDocument::with('client')->find($id);

        if (!$document) {
            return redirect()->back()->with('error', 'File not found.');
        }

        $clientSlug = $document->client->slug;

        $filePath = public_path('uploads/clients/' . $document->file);
        if (file_exists($filePath)) {
            unlink($filePath);
        }

        $document->delete();

        return redirect()->route('admin.clients.show', $clientSlug)->with('success', 'File deleted successfully.');
    }
}
