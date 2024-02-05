<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HistoriResource;
use App\Models\Histori;
use App\Models\Pembelian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HistoriController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = DB::table('historis')
            ->join('pembelians', 'historis.id_transaksi', '=', 'pembelians.id_transaksi')
            ->select('historis.id_transaksi', 'pembelians.no_tiket', 'pembelians.pengunjung', 'pembelians.total', 'pembelians.hari_kunjungan')
            ->get();

        return response()->json([
            'message' => 'Berhasil menampilkan semua histori pembelian tiket pengunjung',
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id_transaksi  = Pembelian::where("id_transaksi","=",$request->input("id_transaksi"))->first();
        
        if ($id_transaksi == null) {
            return response()->json([
                'message' => 'Maaf, id transksi tidak ada',
                'success' => false
            ]);
        } else {
            $post = Histori::create([
                'id_transaksi' => $request->get('id_transaksi'),
                'status' => 1
            ]);
            DB::table('pembelians')
                ->where('id_transaksi', $request->get('id_transaksi'))
                ->update(['status' => 1]);
    
            return response()->json([
                'message' => 'Tiket Berhasil dikonfirmasi',
                'success' => true,
                'data' => new HistoriResource($post)
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = Histori::find($id);
        return response()->json([
            'message' => 'Berhasil menampilkan histori sesuai id',
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Histori::find($id);
        $data->delete();
        return response()->json(['message' => 'Histori berhasil dihapus']);
    }

    public function search($id_transaksi)
    {
        $data = Histori::where('id_transaksi', 'like', '%' . $id_transaksi . '%')->get();

        return response()->json([
            'message' => 'Berhasil menampilkan data yang anda cari',
            'success' => true,
            'data' => $data
        ]);
    }
}
