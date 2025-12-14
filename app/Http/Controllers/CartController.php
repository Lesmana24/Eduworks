<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    // Fungsi Menambah Barang ke Keranjang
    // Di CartController.php

public function addToCart(Request $request, $id)
{
    $product = Product::findOrFail($id);
    $cart = session()->get('cart', []);

    // Ambil jumlah dari input, kalau kosong default 1
    $qty = $request->quantity ? (int)$request->quantity : 1;

    if(isset($cart[$id])) {
        // Jika produk sudah ada, tambahkan quantity yang baru
        $cart[$id]['quantity'] += $qty;
    } else {
        // Jika belum ada, set quantity sesuai input
        $cart[$id] = [
            "name" => $product->name,
            "quantity" => $qty,
            "price" => $product->price,
            "image" => $product->image
        ];
    }

    session()->put('cart', $cart);

    if ($request->ajax()) {
        return response()->json([
            'status' => 'success',
            'message' => $qty . ' produk berhasil ditambahkan!',
            'total_items' => count($cart)
        ]);
    }

    return redirect()->back()->with('success', 'Produk berhasil ditambahkan!');
}

    // Fungsi Halaman Cart (Opsional, menggantikan HomeController::cart)
    public function cart()
    {
        return view('dashboard.cart');
    }

    // Tambahkan method ini di dalam class CartController

    // Update jumlah barang (dipanggil via AJAX/Form)
    public function updateCart(Request $request)
    {
        if($request->id && $request->quantity){
            $cart = session()->get('cart');
            $cart[$request->id]["quantity"] = $request->quantity;
            session()->put('cart', $cart);
            // session()->flash('success', 'Keranjang berhasil diperbarui!');
            return response()->json(['success' => true]);
        }
        return response()->json(['success' => false], 400);
    }

    // Hapus barang dari keranjang
    public function removeCart(Request $request)
    {
        if($request->id) {
            $cart = session()->get('cart');
            if(isset($cart[$request->id])) {
                unset($cart[$request->id]);
                session()->put('cart', $cart);
            }
            session()->flash('success', 'Produk berhasil dihapus dari keranjang');
            return redirect()->back();
        }
    }

    public function checkout()
{
    $cart = session()->get('cart');

    // 1. Cek jika keranjang kosong
    if(!$cart) {
        return redirect()->route('products.index')->with('error', 'Keranjang Anda kosong!');
    }

    // 2. Siapkan Data Pesan WhatsApp
    // Ganti dengan nomor WhatsApp Admin (gunakan format internasional tanpa +, misal 628...)
    $nomorAdmin = '6285934393336';

    // Header Pesan
    $pesan = "Halo Admin TokoSaya, saya ingin memesan produk berikut:\n\n";
    $totalBelanja = 0;

    // 3. Loop Cart untuk Update Database & Susun Pesan
    foreach($cart as $id => $details) {
        $product = Product::find($id);

        if($product) {
            // A. Update Database (Stok & Klik)
            $qtyBeli = $details['quantity'];
            $product->decrement('stock', $qtyBeli);
            $product->increment('click', $qtyBeli); // Atau increment('sold') jika ada

            // B. Susun Detail Pesan per Item
            // Format: - Nama Produk (2x) : Rp 100.000
            $subtotalItem = $details['price'] * $qtyBeli;
            $pesan .= "- " . $details['name'] . " (" . $qtyBeli . "x) : Rp " . number_format($subtotalItem, 0, ',', '.') . "\n";

            $totalBelanja += $subtotalItem;
        }
    }

    // 4. Tambahkan Total & Footer Pesan
    // Hitung PPN (Opsional, sesuaikan dengan logika di view tadi)
    $ppn = $totalBelanja * 0.11;
    $grandTotal = $totalBelanja + $ppn;

    $pesan .= "\nSubtotal: Rp " . number_format($totalBelanja, 0, ',', '.');
    $pesan .= "\nPPN (11%): Rp " . number_format($ppn, 0, ',', '.');
    $pesan .= "\n*Total Bayar: Rp " . number_format($grandTotal, 0, ',', '.') . "*";
    $pesan .= "\n\nMohon info pembayaran selanjutnya. Terima kasih!";

    // 5. Hapus Keranjang
    session()->forget('cart');

    // 6. Redirect ke WhatsApp
    // Gunakan urlencode agar spasi dan enter terbaca oleh link WA
    $urlWhatsApp = "https://api.whatsapp.com/send?phone=" . $nomorAdmin . "&text=" . urlencode($pesan);

    return redirect()->away($urlWhatsApp);
}
}
