<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

// Membuat akun awal untuk admin dan petugas (customer mendaftar sendiri lewat halaman register)
class UserSeeder extends Seeder
{
    public function run(): void
    {
        $akun = [
            ['name' => 'Admin Kafe',   'email' => 'admin@kafe.com',   'password' => 'admin123',   'role' => 'admin'],
            ['name' => 'Petugas Kafe', 'email' => 'petugas@kafe.com', 'password' => 'petugas123', 'role' => 'petugas'],
        ];

        foreach ($akun as $data) {
            // Kalau email sudah ada, hanya role dan nama yang diperbarui (password tidak ditimpa)
            $user = User::firstOrNew(['email' => $data['email']]);
            $user->name = $data['name'];
            $user->role = $data['role'];

            if (! $user->exists) {
                $user->password = $data['password'];
            }

            $user->save();
        }
    }
}
