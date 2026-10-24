<?php

namespace App\Http\Controllers;

// Kelola akun petugas (khusus admin)
class PetugasController extends PenggunaController
{
    protected string $role  = 'petugas';
    protected string $label = 'Petugas';
}
