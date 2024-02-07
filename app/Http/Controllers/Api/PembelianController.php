<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PembelianResource;
use App\Models\Pembelian;
use App\Models\Ticket;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Validator;

class PembelianController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function histori_pembelian($pengunjung)
    {
        $data = DB::table('pembelians')
                    ->where('pengunjung', 'like', '%' . $pengunjung . '%')
                    ->where('status','=','0')
                    ->first();
        
        if ($data == null) {
            return response()->json([
                'message' => 'Maaf, nama pengunjung '. $pengunjung .' tidak melakukan pemesanan tiket',
                'success' => false,
            ]);
        } else {
            return response()->json([
                'message' => 'Berhasil menampilkan pembelian tiket pengunjung '. $pengunjung,
                'success' => true,
                'data' => $data
            ]);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pengunjung' => 'required',
            'jumlah_pembelian' => 'required',
            'pembayaran' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $cariuser = User::where("name", "=", $request->input("pengunjung"))->first();
        $find_tiket  = Ticket::where("no_tiket", "=", $request->input("no_tiket"))->first();

        if ($cariuser == null) {
            return response()->json([
                'message' => 'Maaf, Nama anda tidak ada',
                'success' => false
            ]);
        } else {
            if ($find_tiket == null) {
                return response()->json([
                    'message' => 'Maaf, No tiket yang anda masukkan tidak ada',
                    'success' => false
                ]);
            } else {
                $id_transaksi = Str::random(15);
                $post = Pembelian::create([
                    'pengunjung' => $request->get('pengunjung'),
                    'no_tiket' => $request->get('no_tiket'),
                    'jumlah_pembelian' => $request->get('jumlah_pembelian'),
                    'pembayaran' => $request->get('pembayaran'),
                    'id_transaksi' => $id_transaksi,
                    'total' => $request->get('total'),
                    'status' => 0,
                    'hari_kunjungan' => $request->get('hari_kunjungan')
                ]);

                return response()->json([
                    'message' => 'Pembelian Tiket Sukses',
                    'success' => true,
                    'data' => new PembelianResource($post)
                ]);
            }
        }
    }
}
