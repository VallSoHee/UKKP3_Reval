@extends('layouts.app')

@section('judul', 'Tambah ' . $label)

@section('isi')
<div class="kartu">
    <form method="POST" action="{{ route($rute . '.store') }}">
        @csrf
        @include('pengguna._form')
    </form>
</div>
@endsection
