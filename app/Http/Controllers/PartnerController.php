<?php

namespace App\Http\Controllers;

use App\Models\Partner;
use Illuminate\Http\Request;

class PartnerController extends Controller
{
    public function index()
    {
        $partners = Partner::all();
        return view('backend.partner', compact('partners'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $partner = new Partner();
        $partner->name = $request->name;
        $partner->email = $request->email;
        $partner->phone = $request->phone;
        $partner->website = $request->website;
        if ($request->hasFile('logo')) {
            $image = $request->file('logo');
            $name = time() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('/partners');
            $image->move($destinationPath, $name);
            $partner->logo = 'partners/' . $name;
        }
        $partner->save();
        return redirect()->route('admin.partner.index')->with('success', 'Partner added successfully.');
    }

    //delete partner
    public function destroy($id)
    {
        $partner = Partner::find($id);
        if ($partner) {
            //delete logo
            if ($partner->logo) {
                unlink(public_path($partner->logo));
            }

            $partner->delete();
            return redirect()->route('admin.partner.index')->with('success', 'Partner deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Partner not found.');
        }
    }
}
