<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QRCodeController extends Controller
{
    public function generateQRCode($data)
    {
        return response(QrCode::size(300)->generate($data))
            ->header('Content-Type', 'image/png');
    }
}
