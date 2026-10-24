@extends('layouts.auth')

@section('judul', 'Login')

@section('isi')
<h1>Masuk</h1>
<p class="sub">Login untuk mengirim dan melihat pengaduan.</p>

<form method="POST" action="{{ route('login') }}">
    @csrf

    <div class="form-grup">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" value="{{ old('email') }}" autofocus>
        @error('email') <div class="error">{{ $message }}</div> @enderror
    </div>

    <div class="form-grup">
        <label for="password">Password</label>
        <input type="password" id="password" name="password">
        @error('password') <div class="error">{{ $message }}</div> @enderror
    </div>

    <button type="submit" class="btn">Login</button>
</form>

<p class="pindah">Belum punya akun? <a href="{{ route('register') }}">Daftar</a></p>
@endsection
