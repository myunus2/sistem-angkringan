<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        $imageName = null;

        if ($request->hasFile('image')) {

            $file = $request->file('image');

            $imageName = time().'_'.$file->getClientOriginalName();

            $file->move(public_path('images'), $imageName);
        }

        Product::create([
            'name'  => $request->name,
            'price' => $request->price,
            'image' => $imageName
        ]);

        return redirect('/products/create')->with('success', 'Berhasil disimpan');
    }
}