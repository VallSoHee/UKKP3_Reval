<?php

namespace App\Http\Controllers;

use App\Models\Lampiran;
use Illuminate\Support\Facades\Storage;

class LampiranController extends Controller
{
    // Tampilkan file foto langsung dari storage, tanpa perlu storage:link
    public function tampil(Lampiran $lampiran)
    {
        $path = Storage::disk('public')->path($lampiran->path);

        abort_unless(file_exists($path), 404);

        return response()->file($path);
    }
}
