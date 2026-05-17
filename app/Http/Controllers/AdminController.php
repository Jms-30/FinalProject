<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function dashboard()
    {
        $items = Item::with('category')->get();
        $categories = Category::all();
        return view('admin.dashboard', compact('items', 'categories'));
    }
    public function storeCategory(Request $request)
    {
        $request->validate([
            'name' => 'required|string', 
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return back()->with('success', 'Kategori baru berhasil ditambahkan!');
    }

    public function storeItem(Request $request)
    {
        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|min:5|max:80',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ], [
            'name.min' => 'Nama Barang minimal 5 huruf.',
            'name.max' => 'Nama Barang maksimal 80 huruf.',
            'price.integer' => 'Harga Barang harus berupa angka.',
            'quantity.integer' => 'Jumlah Barang harus menggunakan angka.',
            'image.required' => 'Foto Barang wajib dimasukkan.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('items', 'public');
        }

        Item::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'image' => $imagePath,
        ]);

        return back()->with('success', 'Barang berhasil ditambahkan ke database!');
    }

    public function updateItem(Request $request, $id)
    {
        $item = Item::findOrFail($id);

        $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|min:5|max:80',
            'price' => 'required|integer',
            'quantity' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($item->image) {
                Storage::disk('public')->delete($item->image);
            }
            $item->image = $request->file('image')->store('items', 'public');
        }

        $item->update([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'price' => $request->price,
            'quantity' => $request->quantity,
        ]);

        return back()->with('success', 'Barang berhasil diperbarui!');
    }

    public function destroyItem($id)
    {
        $item = Item::findOrFail($id);
        if ($item->image) {
            Storage::disk('public')->delete($item->image);
        }
        
        $item->delete();

        return back()->with('success', 'Barang berhasil dihapus!');
    }
}