<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // Tampilkan semua produk
    public function index()
    {
        return response()->json(Product::with('details')->get());
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $validated = $request->validate([
      'nama' => 'sometimes|required|string|max:255',
            'merk' => 'sometimes|required|string|max:255',
            'harga' => 'sometimes|required|numeric',
            'stok' => 'sometimes|required|integer',
            'subcategory_id' => 'sometimes|required|exists:product_subcategories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|m    ax:2048',
            'details' => 'array',
            'details.*.warna' => 'required|string',
            'details.*.ukuran' => 'required|string',
            'details.*.bahan' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }
        $product = Product::create($validated);
        if (!empty($validated['details'])) {
            $product->details()->createMany($validated['details']);
        }
        return response()->json($product->load('details'), 201);
    }

    // Tampilkan detail produk
    public function show($id)
    {
        $product = Product::with('details')->findOrFail($id);
        return response()->json($product);
    }

    // Update produk
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'merk' => 'sometimes|required|string|max:255',
            'harga' => 'sometimes|required|numeric',
            'stok' => 'sometimes|required|integer',
            'subcategory_id' => 'sometimes|required|exists:product_subcategories,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|m    ax:2048',
            'details' => 'array',
            'details.*.warna' => 'required|string',
            'details.*.ukuran' => 'required|string',
            'details.*.bahan' => 'nullable|string',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }

            $path = $request->file('image')->store('products', 'public');
            $validated['image'] = $path;
        }

        $product->update($validated);

        if (!empty($validated['details'])) {
            $product->details()->delete();
            $product->details()->createMany($validated['details']);
        }

        return response()->json($product->load('details'));
    }

    // Hapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        // Hapus gambar jika ada
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
