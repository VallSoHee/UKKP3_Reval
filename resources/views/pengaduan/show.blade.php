@extends('layouts.app')

@section('judul', 'Detail Pengaduan')

@section('isi')
<div class="kartu">
    @include('pengaduan._detail')

    <div class="form-aksi">
        <a href="{{ route('pengaduan.index') }}" class="btn btn-abu">Kembali</a>
    </div>
</div>
@endsection
