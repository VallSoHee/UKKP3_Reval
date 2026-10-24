<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul') - Kafe Pengaduan</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="auth-latar">
        <aside class="auth-sisi">
            <div class="brand">Kafe Pengaduan</div>

            <div class="ilustrasi">
                <svg class="ilustrasi-gambar" viewBox="0 0 400 440" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="#fff" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                    <!-- cahaya lampu -->
                    <path d="M170 142 L40 380 H360 L230 142 Z" fill="#fff" fill-opacity=".07" stroke="none"/>
                    <!-- lampu gantung -->
                    <path d="M200 0 V78"/>
                    <path d="M148 134 Q148 82 200 82 Q252 82 252 134 Z" fill="#fff" fill-opacity=".16"/>
                    <circle cx="200" cy="146" r="9" fill="#fff" stroke="none"/>
                    <!-- uap -->
                    <path d="M172 248 q-14 -22 0 -44 t0 -44" opacity=".85"/>
                    <path d="M200 240 q-14 -26 0 -52 t0 -52" opacity=".85"/>
                    <path d="M228 248 q-14 -22 0 -44 t0 -44" opacity=".85"/>
                    <!-- cangkir -->
                    <path d="M265 288 Q306 286 306 320 Q306 352 258 348"/>
                    <path d="M134 270 H266 V316 Q266 366 200 366 Q134 366 134 316 Z" fill="#fff" fill-opacity=".14"/>
                    <ellipse cx="200" cy="270" rx="66" ry="10" fill="#fff" fill-opacity=".4"/>
                    <!-- alas cangkir dan meja -->
                    <ellipse cx="200" cy="372" rx="98" ry="13"/>
                    <path d="M24 392 H376"/>
                    <!-- papan nomor meja -->
                    <path d="M36 392 L44 338 H92 L100 392" fill="#fff" fill-opacity=".14"/>
                    <text x="68" y="357" text-anchor="middle" font-family="Georgia, serif" font-size="9" letter-spacing="1.5" fill="#fff" stroke="none">MEJA</text>
                    <text x="68" y="382" text-anchor="middle" font-family="Georgia, serif" font-size="22" font-weight="700" fill="#fff" stroke="none">12</text>
                    <!-- biji kopi -->
                    <g transform="translate(332 378) rotate(-25)"><ellipse rx="11" ry="7" fill="#fff" fill-opacity=".2"/><path d="M-9 0 Q0 -5 9 0" stroke-width="1.8"/></g>
                    <g transform="translate(356 384) rotate(18)"><ellipse rx="11" ry="7" fill="#fff" fill-opacity=".2"/><path d="M-9 0 Q0 5 9 0" stroke-width="1.8"/></g>
                </svg>
            </div>

            <p class="catatan">Setiap pengaduan ditanggapi langsung oleh petugas.</p>
        </aside>

        <main class="auth-isi">
            <div class="auth-kartu">
                @if (session('sukses'))
                    <div class="pesan pesan-sukses">{{ session('sukses') }}</div>
                @endif

                @yield('isi')
            </div>
        </main>
    </div>
</body>
</html>
