<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::all();
        return view('backend.galleries', compact('galleries'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $gallery = new Gallery();
        $gallery->title = $request->title;
        $gallery->description = $request->description;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time()  . $image->getClientOriginalName();
            $destinationPath = public_path('/galleries');
            $image->move($destinationPath, $name);
            $gallery->image = 'galleries/' . $name;
        }
        //create slug
        $gallery->slug = \Str::slug($request->title);
        $gallery->save();
        return redirect()->route('admin.gallery.index')->with('success', 'Gallery added successfully.');
    }

    //delete partner
    public function destroy($id)
    {
        $gallery = Gallery::find($id);
        if ($gallery) {
            //delete logo
            if ($gallery->image) {
                unlink(public_path($gallery->image));
            }

            $gallery->delete();
            return redirect()->route('admin.gallery.index')->with('success', 'Gallery deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Gallery not found.');
        }
    }

    //update trending
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $gallery = Gallery::find($id);
        if ($gallery) {
            $gallery->title = $request->title;
            $gallery->slug = \Str::slug($request->title);
            $gallery->description = $request->description;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalName();
                $destinationPath = public_path('/galleries');
                $image->move($destinationPath, $name);
                $gallery->image = 'galleries/' . $name;
            }
            $gallery->save();
            return redirect()->route('admin.gallery.index')->with('success', 'Gallery updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Gallery not found.');
        }
    }
}
