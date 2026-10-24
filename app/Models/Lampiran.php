<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lampiran extends Model
{
    protected $fillable = ['pengaduan_id', 'path', 'nama_asli'];

    public function pengaduan()
    {
        return $this->belongsTo(Pengaduan::class);
    }
}
