<?php

namespace App\Http\Controllers;

use App\Models\Trending;
use Illuminate\Http\Request;

class TrendingController extends Controller
{
    public function index()
    {
        $trendings = Trending::all();
        return view('backend.trending', compact('trendings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'description' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
        $trends = new Trending();
        $trends->title = $request->title;
        $trends->description = $request->description;
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $name = time()  . $image->getClientOriginalName();
            $destinationPath = public_path('/trending');
            $image->move($destinationPath, $name);
            $trends->image = 'trending/' . $name;
        }
        //create slug
        $trends->slug = \Str::slug($request->title);
        $trends->save();
        return redirect()->route('admin.trending.index')->with('success', 'Trending added successfully.');
    }

    //delete partner
    public function destroy($id)
    {
        $trends = Trending::find($id);
        if ($trends) {
            //delete logo
            if ($trends->image) {
                unlink(public_path($trends->image));
            }

            $trends->delete();
            return redirect()->route('admin.trending.index')->with('success', 'Trending deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Partner not found.');
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
        $trends = Trending::find($id);
        if ($trends) {
            $trends->title = $request->title;
            $trends->description = $request->description;
            if ($request->hasFile('image')) {
                $image = $request->file('image');
                $name = time() . '.' . $image->getClientOriginalExtension();
                $destinationPath = public_path('/trending');
                $image->move($destinationPath, $name);
                $trends->image = 'trending/' . $name;
            }
            $trends->save();
            return redirect()->route('admin.trending.index')->with('success', 'Trending updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Trending not found.');
        }
    }
}
