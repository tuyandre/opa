<?php

namespace App\Http\Controllers;

use App\Models\ContactUs;
use Illuminate\Http\Request;

class ContactUsController extends Controller
{
    public function index()
    {
        $contact_us = ContactUs::all();
        return view('backend.contact_us', compact('contact_us'));
//        return view('backend.contact_us_test');
    }

    public function show($id)
    {
        $contact_us = ContactUs::find($id);
        $contact_us->is_read = true;
        $contact_us->save();

        return view('backend.contact_us_show', compact('contact_us'));
    }

    public function reply(Request $request, $id)
    {
        $contact_us = ContactUs::find($id);
        $contact_us->is_replied = true;
        $contact_us->replied_by = auth()->user()->id;
        $contact_us->save();

        return redirect()->route('contact_us.index')->with('success', 'Reply sent successfully.');
    }

    public function destroy($id)
    {
        $contact_us = ContactUs::find($id);
        $contact_us->delete();

        return redirect()->route('contact_us.index')->with('success', 'Contact us deleted successfully.');
    }

    public function destroyAll()
    {
        ContactUs::truncate();

        return redirect()->route('contact_us.index')->with('success', 'All contact us deleted successfully.');
    }

    public function markAllAsRead()
    {
        ContactUs::where('is_read', false)->update(['is_read' => true]);

        return redirect()->route('contact_us.index')->with('success', 'All contact us marked as read successfully.');
    }

    //save contact us form data
    public function saveContactUs(Request $request)
    {
        $request->validate([
            'full_name' => 'required',
            'telephone' => 'required',
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ]);

        $contact_us = new ContactUs();
        $contact_us->full_name = $request->full_name;
        $contact_us->telephone = $request->telephone;
        $contact_us->email = $request->email;
        $contact_us->subject = $request->subject;
        $contact_us->message = $request->message;
        $contact_us->save();

        return redirect()->back()->with('success', 'Your message has been sent successfully.');
    }
}
