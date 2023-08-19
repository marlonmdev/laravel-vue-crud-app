<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use App\Http\Resources\ProductResource;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::latest()->filter(request(['search']))->get();
        return ProductResource::collection($products);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
        $validated = $request->validated();

        $validated['slug'] = Str::slug($validated['name']);
        if($request->hasFile('image')){
            $validated['image'] = $request->file('image')->store('images', 'public');
        }
        
        $created = Product::create($validated);
        
        return $created
            ? response()->json(['status' => 200, 'message' => 'Saved Successfully'])
            : response()->json(['status' => 500, 'message' => 'Something Went Wrong']);
          
        
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        return $product;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $validated = $request->validated();
        
        $validated['slug'] = Str::slug($validated['name']);
        if($request->hasFile('image')){
            $validated['image'] = $request->file('image')->store('images', 'public');
            // Delete old uploaded image inside the storage directory
            if($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
        }
        
        $product->update($validated);
        return response()->json(['message' => 'Product Updated Successfully']);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Product Deleted Successfully']);
    }
}
