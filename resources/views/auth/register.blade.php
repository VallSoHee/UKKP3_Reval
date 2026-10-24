@extends('layouts.auth')

@section('judul', 'Daftar')

@section('isi')
<h1>Buat akun</h1>
<p class="sub">Isi data di bawah untuk mendaftar.</p>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <div class="form-grup">
        <label for="name">Nama</label>
        <input type="text" id="name" name="name" value="{{ old('name') }}" autofocus>
        @error('name') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-grup">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}">
        @error('email') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-grup">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
        <div class="bantuan">Minimal 6 karakter.</div>
        @error('password') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-grup">
        <label for="password_confirmation">Ulangi Password</label>
        <input type="password" id="password_confirmation" name="password_confirmation">
    </div>

    <button type="submit" class="btn">Daftar</button>
</form>

<p class="pindah">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
@endsection
