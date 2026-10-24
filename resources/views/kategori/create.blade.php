@extends('layouts.app')

@section('judul', 'Tambah Kategori')

@section('isi')
<div class="kartu">
    <form method="POST" action="{{ route('kategori.store') }}">
        @csrf
        @include('kategori._form')
    </form>
</div>
@endsection
