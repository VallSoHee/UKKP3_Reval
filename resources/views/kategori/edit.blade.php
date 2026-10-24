@extends('layouts.app')

@section('judul', 'Ubah Kategori')

@section('isi')
<div class="kartu">
    <form method="POST" action="{{ route('kategori.update', $kategori) }}">
        @csrf
        @method('PUT')
        @include('kategori._form')
    </form>
</div>
@endsection
