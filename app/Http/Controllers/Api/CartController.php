<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartResorce;
use App\Http\Resources\PembelianResource;
use App\Models\Cart;
use App\Models\Pembayaran;
use App\Models\Pembelian;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CartController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'jumlah_beli' => 'required',
            'hari_kunjungan' => 'required',
            'total_beli' => 'required',
            'kategori_tiket' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $find_tiket  = Ticket::where("kategori", "=", $request->input("kategori_tiket"))->first();

        if ($find_tiket == null) {
            return response()->json([
                'message' => 'Maaf, Kategori tiket tidak ada',
                'success' => false
            ]);
        } else {
            $data = Cart::create([
                'hari_kunjungan' => $request->get('hari_kunjungan'),
                'jumlah_beli' => $request->get('jumlah_beli'),
                'total_beli' => $request->get('total_beli'),
                'kategori_tiket' => $request->get('kategori_tiket'),
                'kode' => 'JNB-01',
            ]);
            $beli = Pembelian::create([
                'jumlah_beli' => $request->get('jumlah_beli'),
                'total_beli' => $request->get('total_beli'),
                'kategori_tiket' => $request->get('kategori_tiket'),
                'status' => '0',
                'hari_kunjungan' => $request->get('hari_kunjungan'),
                'id_transaksi' => '',
                'kode' => 'JNB-01'
            ]);

            return response()->json([
                'message' => 'Tiket berhasil dimasukkan ke keranjang',
                'success' => true,
                'cart' => new CartResorce($data),
                'beli' => new PembelianResource($beli)
            ]);
        }
    }

    public function destroy($id)
    {
        $data = Cart::find($id);
        $data->delete();
        return response()->json(['message' => 'Cart berhasil dihapus']);
    }

    public function checkout()
    {
        $id_transaksi = Str::random(15);

        DB::table('carts')
                ->where('kode', '=', 'JNB-01')
                ->delete();
        DB::table('pembelians')
                ->where('kode', '=', 'JNB-01')
                ->update(['id_transaksi' => $id_transaksi, 'status' => '1']);
        Pembayaran::create([
            'id_transaksi' => $id_transaksi,
            'status_pembayaran' => 'Belum Bayar',
            'payment' => '',
            'total' => '',
        ]);

        return response()->json([
            'message' => 'checkout sukses, silahkan melakukan pembayaran!',
            'success' => true,
        ]);
    }
}
