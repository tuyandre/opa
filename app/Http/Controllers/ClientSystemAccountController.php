<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\ClientSystemAccount;
use Illuminate\Http\Request;

class ClientSystemAccountController extends Controller
{
    public function store(Request $request, $slug)
    {
        $client = Client::where('slug', $slug)->firstOrFail();

        $request->validate([
            'app_name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'reset_phone_number' => 'nullable|string|max:50',
        ]);

        ClientSystemAccount::create([
            'client_id' => $client->id,
            'app_name' => $request->app_name,
            'url' => $request->url,
            'username' => $request->username,
            'password' => $request->password,
            'reset_phone_number' => $request->reset_phone_number,
            'created_by' => auth()->id(),
        ]);

        return redirect()->route('admin.clients.show', $client->slug)->with('success', 'System account added successfully.');
    }

    public function update(Request $request, $id)
    {
        $account = ClientSystemAccount::with('client')->findOrFail($id);

        $request->validate([
            'app_name' => 'required|string|max:255',
            'url' => 'nullable|string|max:255',
            'username' => 'nullable|string|max:255',
            'password' => 'nullable|string|max:255',
            'reset_phone_number' => 'nullable|string|max:50',
        ]);

        $data = $request->only(['app_name', 'url', 'username', 'reset_phone_number']);
        if ($request->filled('password')) {
            $data['password'] = $request->password;
        }
        $account->update($data);

        return redirect()->route('admin.clients.show', $account->client->slug)->with('success', 'System account updated successfully.');
    }

    public function destroy($id)
    {
        $account = ClientSystemAccount::with('client')->find($id);

        if (!$account) {
            return redirect()->back()->with('error', 'System account not found.');
        }

        $clientSlug = $account->client->slug;
        $account->delete();

        return redirect()->route('admin.clients.show', $clientSlug)->with('success', 'System account deleted successfully.');
    }
}
