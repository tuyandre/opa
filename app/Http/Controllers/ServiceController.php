<?php

namespace App\Http\Controllers;

use App\Models\TrainingService;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index()
    {
        $services = TrainingService::all();
        return view('backend.settings.services', compact('services'));
    }
    //store service
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $service = new TrainingService();
        $service->title = $request->title;
        $service->description = $request->description;
        $service->save();
        return redirect()->back()->with('success', 'Service added successfully.');
    }

    //delete service
    public function destroy($id)
    {
        $service = TrainingService::find($id);
        $service->delete();
        return redirect()->back()->with('success', 'Service deleted successfully.');
    }

    //update service
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required'
        ]);
        $service = TrainingService::find($id);
        $service->title = $request->title;
        $service->description = $request->description;
        $service->is_active = $request->is_active;
        $service->save();
        return redirect()->back()->with('success', 'Service updated successfully.');
    }

}
