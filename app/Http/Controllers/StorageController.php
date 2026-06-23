<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;

class StorageController extends Controller
{
    /**
     * Serve files from public storage
     */
    public function file($path)
    {
        $file = storage_path('app/public/' . $path);

        // Security: prevent directory traversal
        if (strpos(realpath($file) ?: '', realpath(storage_path('app/public')) ?: '') !== 0) {
            abort(403);
        }

        if (!file_exists($file)) {
            abort(404);
        }

        return response()->file($file);
    }
}
