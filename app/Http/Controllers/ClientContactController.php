<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientContact;
use Illuminate\Http\Request;

class ClientContactController extends Controller
{
    public function store(Request $request, $slug)
    {
        $client = Client::where('slug', $slug)->firstOrFail();

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        $client->contacts()->create($request->only(['name', 'phone', 'email', 'position']));

        return redirect()->route('admin.clients.show', $client->slug)->with('success', 'Contact added successfully.');
    }

    public function update(Request $request, $id)
    {
        $contact = ClientContact::with('client')->findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:50',
            'email' => 'nullable|email|max:255',
            'position' => 'nullable|string|max:255',
        ]);

        $contact->update($request->only(['name', 'phone', 'email', 'position']));

        return redirect()->route('admin.clients.show', $contact->client->slug)->with('success', 'Contact updated successfully.');
    }

    public function destroy($id)
    {
        $contact = ClientContact::with('client')->find($id);

        if (!$contact) {
            return redirect()->back()->with('error', 'Contact not found.');
        }

        $clientSlug = $contact->client->slug;
        $contact->delete();

        return redirect()->route('admin.clients.show', $clientSlug)->with('success', 'Contact deleted successfully.');
    }
}
