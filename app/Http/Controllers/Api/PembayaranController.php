<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Histori;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class PembayaranController extends Controller
{
    public function bayar(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment' => 'required',
            'id_transaksi' => 'required',
            'bayar' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $bayar = $request->input('bayar');

        $id_transaksi = Pembayaran::where("id_transaksi", "=", $request->input("id_transaksi"))->first();
        $totalHarga = DB::table('pembelians')->sum('total_beli');

        if ($id_transaksi == null) {
            return response()->json([
                'message' => 'Maaf, id transaksi tidak ditemukan',
                'success' => false
            ]);
        } else {
            if ($totalHarga != $bayar) {
                return response()->json([
                    'message' => 'Pembayaran gagal',
                    'success' => false
                ]);
            } else {
                DB::table('pembayarans')
                    ->where('id_transaksi', '=', $request->input('id_transaksi'))
                    ->update(['payment' => $request->input('payment'), 'status_pembayaran' => 'Sudah Bayar']);
                DB::table('pembelians')
                    ->where('id_transaksi', '=', $request->input('id_transaksi'))
                    ->update(['status' => '2']);
                Histori::create([
                    'id_transaksi' => $request->get('id_transaksu'),
                    'status' => '1'
                ]);

                return response()->json([
                    'message' => 'Pembayaran Sukses, Silahkan cetak Tiket',
                    'success' => true
                ]);
            }
        }
    }
}
