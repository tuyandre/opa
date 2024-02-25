<?php

namespace App\Http\Controllers;

use App\Models\TrainingMaterial;
use Illuminate\Http\Request;

class DownloadController extends Controller
{
    public function downloadCertificate($filename)
    {
        $filePath = public_path('uploads/certificates/' . $filename);

        // Check if file exists
        if (file_exists($filePath)) {
            return response()->download($filePath);
        } else {
            abort(404, 'File not found');
        }
    }
    public function downloadMaterial($file)
    {
            $filePath = public_path('uploads/trainings/' . $file);

            // Check if file exists
            if (file_exists($filePath)) {
                return response()->download($filePath);
            } else {
                abort(404, 'File not found');
            }

    }
}
