<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Participant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class QrCodeController extends Controller
{
    public function showQrCode($filename)
    {
        $filePath = "public/qrImage/{$filename}";

        // Check if the file exists
        if (Storage::exists($filePath)) {
            $file = Storage::get($filePath);

            // Return the image with appropriate headers
            return Response::make($file, 200, [
                'Content-Type' => 'image/png',
                'Content-Disposition' => 'inline; filename="' . $filename . '"',
            ]);
        }

        // Return a 404 response if the file is not found
        return abort(404);
    }
}
