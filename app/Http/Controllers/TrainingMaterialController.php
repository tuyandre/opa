<?php

namespace App\Http\Controllers;

use App\Models\TrainingMaterial;
use Illuminate\Http\Request;

class TrainingMaterialController extends Controller
{
    public function index()
    {
        $materials = TrainingMaterial::where('status','Active')->get();
        return view('backend.students.training_materials', compact('materials'));
    }

    public function materials()
    {
        $materials = TrainingMaterial::where('status','Active')->get();
        return view('backend.materials.trainings', compact('materials'));
    }


    //store training material
    public function storeMaterial(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'file' => 'required|mimes:pdf,doc,docx'
        ]);

        $file = $request->file('file');
        $file_name = time() . '_'.$file->getClientOriginalName(). '.' . $file->getClientOriginalExtension();
        $file->move(public_path('uploads/trainings'), $file_name);

        $material = new TrainingMaterial();
        $material->title = $request->title;
        $material->description = $request->description;
        $material->status = 'Active';
        $material->file = $file_name;
        $material->save();
        return redirect()->back()->with('success', 'Material added successfully');
    }

    //delete training material
    public function destroy($id)
    {
        $material = TrainingMaterial::find($id);
        if (!$material) {
            return redirect()->back()->with('error', 'Material not found');
        }
        //delete material file
        if (file_exists(public_path('uploads/trainings/'.$material->file))){
            unlink(public_path('uploads/trainings/'.$material->file));
        }
        $material->delete();
        return redirect()->back()->with('success', 'Material deleted successfully');
    }
}
