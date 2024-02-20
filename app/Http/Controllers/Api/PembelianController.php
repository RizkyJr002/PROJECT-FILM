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
}
