<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transaction = Transaction::latest()->with('product')->paginate(20);

        //render view with transaction
        $user = User::all();
        $product = Product::all();
        return view('transaction.index', compact('transaction', 'user', 'product'));
    }

    public function store(Request $request)
    {
        // validasi
        $request->validate([
            'user_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required',
            'total_harga' => 'required',
        ]);
        DB::beginTransaction();
        // Pengurangan stok

        // $product = Product::find($request->product_id)->decrement('stock', $request->quantity);
        // $product = Product::find($request->product_id);
        // $product->stock = $product->stock - $request->quantity;
        // $product->save();
        // Simpan transaksi
        Transaction::create([
            'user_id' => $request->user_id,
            'product_id' => $request->product_id,
            'harga' => $request->harga,
            'quantity' => $request->quantity,
            'total' => $request->total_harga,
        ]);

        DB::commit();

        return response()->json([
            'status' => "success",
            'message' => "data berhasil disimpan"
        ]);
    }
}
