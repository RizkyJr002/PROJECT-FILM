<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrCodeController extends Controller
{
    public function generateQrCode($data)
    {
        $qrCode = QrCode::size(300)->generate($data);
        $qrCodeUrl = 'data:image/png;base64,' . base64_encode($qrCode);

        return response()->json(['qr_code_url' => $qrCodeUrl])->header('Content-Type', 'image/png');
    }

    public function showQrCode($data)
    {
        $qrCodeUrl = route('api.generate-qrcode', ['data' => $data]);

        return view('qr-code', compact('qrCodeUrl'));
    }
}
