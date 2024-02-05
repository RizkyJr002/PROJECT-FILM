<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TicketResource;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $data = Ticket::all();
        return response()->json([
            'message' => 'Berhasil menampilkan semua tiket',
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'kategori' => 'required',
            'harga' => 'required|numeric',
            'jadwal' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'data' => [],
                'message' => $validator->errors(),
                'success' => false
            ]);
        }

        $no_tiket = Str::random(15);

        $post = Ticket::create([
            'kategori' => $request->get('kategori'),
            'harga' => $request->get('harga'),
            'jadwal' => $request->get('jadwal'),
            'no_tiket' => $no_tiket
        ]);

        return response()->json([
            'message' => 'Berhasil menambahkan tiket',
            'success' => true,
            'data' => new TicketResource($post)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $data = Ticket::find($id);
        return response()->json([
            'message' => 'Berhasil menampilkan tiket sesuai id',
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $data = Ticket::find($id);
        $data->update($request->all());
        return response()->json([
            'message' => 'Tiket sukses di update.',
            'success' => true,
            'data' => $data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $data = Ticket::find($id);
        $data->delete();
        return response()->json(['message' => 'Tiket berhasil dihapus']);
    }
}