<?php

namespace App\Http\Controllers;
use App\Models\Photo;

use Illuminate\Http\Request;



class PhotoController extends Controller
{
    public function create(){
        return view('upload');
    }

    public function storeSingle(Request $request){
        $request->validate([
            'image' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);
        $image=$request->file('image');
        $name = time().'_'.$image->getClientOriginalName();
        $image->move(public_path('images'),$name);

        Photo::create(['image' => $name]);
        return back()->with('success','Single image uploaded Successfully!');
    }

    public function storeMultiple(Request $request){
    
        $request->validate([
        'image.*' => 'required|image|mimes:jpg,jpeg,png,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {

        foreach ($request->file('image') as $image) {

            $name = time().'_'.$image->getClientOriginalName();
            $image->move(public_path('images'), $name);

            Photo::create(['image' => $name]);
        }
    }

    return back()->with('success', 'Multiple images uploaded successfully!');
 }
}
