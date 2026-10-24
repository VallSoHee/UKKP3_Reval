@extends('layouts.app')

@section('judul', 'Form Pengaduan Customer')

@section('isi')
<div class="kartu">
    <form method="POST" action="{{ route('pengaduan.store') }}" enctype="multipart/form-data">
        @csrf
        @include('pengaduan._form')
    </form>
</div>
@endsection
