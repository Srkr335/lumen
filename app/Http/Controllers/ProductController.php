<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{

    public function index()
    {
        
        $products = Product::all();
        return response()->json($products);

    }


    public function store(Request $request)
    {

        $this->validate($request, [
            'title' => 'required',
            'price' => 'required',
            'photo' => 'required',
            'description' => 'required'

         ]);





        $product = new Product();
       
        // image upload
        if($request->hasFile('photo')) {

        $allowedfileExtension=['pdf','jpg','png'];
        $file = $request->file('photo');
        $extenstion = $file->getClientOriginalExtension();
        $check = in_array($extenstion, $allowedfileExtension);

        if($check){
            $name = time() . $file->getClientOriginalName();
            $file->move('images', $name);
            $product->photo = $name;
        }
        }


       
        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        $product->save();
        return response()->json($product);


    }


    public function show($id)
    {
        
        $product = Product::find($id);
        return response()->json($product);
    }


    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'title' => 'required',
            'price' => 'required',
            'photo' => 'required',
            'description' => 'required'

         ]);

        $product = Product::find($id);


        // image upload
        if($request->hasFile('photo')) {

            $allowedfileExtension=['pdf','jpg','png'];
            $file = $request->file('photo');
            $extenstion = $file->getClientOriginalExtension();
            $check = in_array($extenstion, $allowedfileExtension);

            if($check){
                $name = time() . $file->getClientOriginalName();
                $file->move('images', $name);
                $product->photo = $name;
            }
            }
        // text Data
        $product->title = $request->input('title');
        $product->price = $request->input('price');
        $product->description = $request->input('description');

        $product->save();

        return response()->json($product);

    }


    public function destroy($id)
    {
        
        $product = Product::find($id);
        $product->delete();
        return response()->json('Product Deleted Successfully');

    }
}
