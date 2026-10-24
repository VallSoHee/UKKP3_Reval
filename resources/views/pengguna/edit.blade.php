@extends('layouts.app')

@section('judul', 'Ubah ' . $label)

@section('isi')
<div class="kartu">
    <form method="POST" action="{{ route($rute . '.update', $user) }}">
        @csrf
        @method('PUT')
        @include('pengguna._form')
    </form>
</div>
@endsection
