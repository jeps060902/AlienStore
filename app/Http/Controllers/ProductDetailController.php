<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;

class ProductDetailController extends Controller
{
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'warna' => 'required|string',
            'ukuran' => 'required|string',
            'bahan' => 'nullable|string',
        ]);

        $detail = $product->details()->create($validated);

        return response()->json($detail, 201);
    }

    public function update(Request $request, ProductDetail $detail)
    {
        $validated = $request->validate([
            'warna' => 'required|string',
            'ukuran' => 'required|string',
            'bahan' => 'nullable|string',
        ]);

        $detail->update($validated);

        return response()->json($detail, 200);
    }

    public function destroy(ProductDetail $detail)
    {
        $detail->delete();
        return response()->json(null, 204);
    }
}
