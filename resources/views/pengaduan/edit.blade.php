@extends('layouts.app')

@section('judul', 'Ubah Pengaduan')

@section('isi')
<div class="kartu">
    <form method="POST" action="{{ route('pengaduan.update', $pengaduan) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('pengaduan._form')
    </form>
</div>
@endsection
