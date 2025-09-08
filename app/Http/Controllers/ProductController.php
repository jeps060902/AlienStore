<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Tampilkan semua produk
    public function index()
    {
        return response()->json(Product::all());
    }
// {
//   "nama": "Sepatu Olahraga",
//   "merk": "Adidas",
//   "harga": 950000,
//   "stok": 15,
//   "details": [
//     { "warna": "Hitam", "ukuran": "42", "bahan": "Kulit" },
//     { "warna": "Putih", "ukuran": "41", "bahan": "Canvas" }
//   ]
// }

    // Simpan produk baru
    public function store(Request $request)
{
    $validated = $request->validate([
        'nama' => 'required|string|max:255',
        'merk' => 'required|string|max:255',
        'harga' => 'required|numeric',
        'stok' => 'required|integer',
        'details' => 'array',
        'details.*.warna' => 'required|string',
        'details.*.ukuran' => 'required|string',
        'details.*.bahan' => 'nullable|string',
    ]);

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
        'details' => 'array',
        'details.*.warna' => 'required|string',
        'details.*.ukuran' => 'required|string',
        'details.*.bahan' => 'nullable|string',
    ]);

    $product->update($validated);

    if (!empty($validated['details'])) {
        $product->details()->delete(); // hapus lama
        $product->details()->createMany($validated['details']); // tambah baru
    }

    return response()->json($product->load('details'));
}


    // Hapus produk
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return response()->json(['message' => 'Produk berhasil dihapus']);
    }
}
