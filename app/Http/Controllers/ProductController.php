<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get all products
        $products = Product::latest()->paginate(20);

        //render view with products
        return view('products.index', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('products.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        //validate form
        $request->validate([
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);

        //upload image
        $image = $request->file('image');
        $image->storeAs('public/products', $image->hashName());

        //create product
        Product::create([
            'image'         => $image->hashName(),
            'title'         => $request->title,
            'description'   => $request->description,
            'price'         => $request->price,
            'stock'         => $request->stock
        ]);

        //redirect to index
        // return to_route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
        return response()->json([
            'status' => "success",
            'message' => "berhasil disimpan"
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //render view with product
        return view('products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {

        //render view with product
        // return view('products.edit', compact('product'));

        return response()->json([
            'status' => "success",
            'message' => "Data berhasil diambil",
            'data' => $product
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //validate form
        $request->validate([
            'image'         => 'image|mimes:jpeg,jpg,png|max:2048',
            'title'         => 'required|min:5',
            'description'   => 'required|min:10',
            'price'         => 'required|numeric',
            'stock'         => 'required|numeric'
        ]);


        //check if image is uploaded
        if ($request->hasFile('image')) {

            //upload new image
            $image = $request->file('image');
            $image->storeAs('public/products', $image->hashName());

            //delete old image
            Storage::delete('public/products/' . $product->image);

            //update product with new image
            $product->update([
                'image'         => $image->hashName(),
                'title'         => $request->title,
                'description'   => $request->description,
                'price'         => $request->price,
                'stock'         => $request->stock
            ]);
        } else {

            //update product without image
            $product->update([
                'title'         => $request->title,
                'description'   => $request->description,
                'price'         => $request->price,
                'stock'         => $request->stock
            ]);
        }

        //redirect to index
        // return to_route('products.index')->with(['success' => 'Data Berhasil Disimpan!']);
        return response()->json([
            'status' => "success",
            'message' => "berhasil disimpan"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // dd($product);
        //delete image
        Storage::delete('public/products/' . $product->image);

        //delete product
        $product->delete();

        //redirect to index
        // return to_route('products.index')->with(['success' => 'Data Berhasil Dihapus!']);
        return response()->json([
            'status' => "success",
            'message' => "berhasil Dihapus"
        ]);
    }

    public function detail($id = null)
    {
        $product = Product::find($id);
        return response()->json([
            'data' => $product ? $product : null,
            'message' => $product ? "Berhasil diambil" : "tidak ada data"
        ]);
    }
}
