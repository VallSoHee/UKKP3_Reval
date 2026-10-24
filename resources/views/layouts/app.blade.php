<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('judul') - Kafe Pengaduan</title>
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    <div class="sidebar">
        <div class="brand">Kafe Pengaduan</div>

        <a href="{{ route('pengaduan.index') }}" class="{{ request()->routeIs('home', 'pengaduan.*') ? 'aktif' : '' }}">Pengaduan</a>

        <div class="sidebar-bawah">
            {{-- Tampil kalau sudah login: nama user dan tombol logout --}}
            @auth
                <div class="user">
                    <strong>{{ auth()->user()->name }}</strong>
                    <span>{{ auth()->user()->email }}</span>
                </div>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-abu">Logout</button>
                </form>
            @endauth

            {{-- Tampil kalau belum login (misalnya membuka halaman kategori lewat URL) --}}
            @guest
                <a href="{{ route('login') }}">Login</a>
            @endguest
        </div>
    </div>

    <div class="konten">
        <div class="topbar">@yield('judul')</div>

        <div class="isi">
            @if (session('sukses'))
                <div class="pesan pesan-sukses">{{ session('sukses') }}</div>
            @endif
            @if (session('gagal'))
                <div class="pesan pesan-gagal">{{ session('gagal') }}</div>
            @endif

            @yield('isi')
        </div>
    </div>
</body>
</html>
