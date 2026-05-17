<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function index()
    {
        $items = Item::with('category')->get();
        return view('user.katalog', compact('items'));
    }
    public function showCart()
    {
        $cart = session()->get('cart', []);
        return view('user.faktur', compact('cart'));
    }
    public function addToCart(Request $request, $id)
    {
        $item = Item::findOrFail($id);
        if ($item->quantity <= 0) {
            return back()->with('error', 'Barang sudah habis, silakan tunggu hingga barang di-restock ulang.');
        }

        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            if ($cart[$id]['quantity'] + 1 > $item->quantity) {
                return back()->with('error', 'Jumlah pembelian melebihi stok yang tersedia saat ini.');
            }
            $cart[$id]['quantity']++;
        } else {
            $cart[$id] = [
                "name" => $item->name,
                "quantity" => 1,
                "price" => $item->price,
                "category" => $item->category->name,
                "image" => $item->image
            ];
        }

        session()->put('cart', $cart);
        return back()->with('success', 'Barang berhasil dimasukkan ke faktur!');
    }

    public function updateCart(Request $request)
    {
        if ($request->id && $request->quantity) {
            $item = Item::findOrFail($request->id);
            
            if ($request->quantity > $item->quantity) {
                return response()->json(['error' => 'Stok tidak mencukupi.'], 400);
            }

            $cart = session()->get('cart', []);
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            return response()->json(['success' => 'Faktur berhasil diperbarui.']);
        }
    }

    public function removeFromCart(Request $request)
    {
        if ($request->id) {
            $cart = session()->get('cart', []);
            if (isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            return response()->json(['success' => 'Barang dihapus dari faktur.']);
        }
    }

    public function checkout(Request $request)
    {
        $cart = session()->get('cart', []);
        if (empty($cart)) {
            return back()->with('error', 'Faktur Anda masih kosong. Silakan pilih barang terlebih dahulu.');
        }
        $request->validate([
            'address' => 'required|string|min:10|max:100',
            'postal_code' => 'required|digits:5',
        ], [
            'address.min' => 'Alamat Pengiriman minimal 10 huruf.',
            'address.max' => 'Alamat Pengiriman maksimal 100 huruf.',
            'postal_code.digits' => 'Kode Pos harus tepat 5 digit angka.',
        ]);

        $totalPrice = 0;
        foreach ($cart as $id => $details) {
            $item = Item::findOrFail($id);
            if ($item->quantity < $details['quantity']) {
                return back()->with('error', "Stok barang {$item->name} mendadak tidak mencukupi.");
            }
            
            $totalPrice += $details['price'] * $details['quantity'];
            $item->decrement('quantity', $details['quantity']);
        }

        $invoiceNumber = 'INV-' . date('Ymd') . '-' . strtoupper(bin2hex(random_bytes(3)));

        $invoice = Invoice::create([
            'user_id' => Auth::id(),
            'invoice_number' => $invoiceNumber,
            'address' => $request->address,
            'postal_code' => $request->postal_code,
            'items' => $cart,
            'total_price' => $totalPrice,
        ]);

        session()->forget('cart');

        return redirect()->route('user.invoice.print', $invoice->id)->with('success', 'Faktur berhasil disimpan!');
    }

    public function printInvoice($id)
    {
        $invoice = Invoice::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        return view('user.cetak_faktur', compact('invoice'));
    }
}