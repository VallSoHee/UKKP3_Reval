@extends('layouts.app')

@section('judul', 'Tanggapi Pengaduan')

@section('isi')
<div class="kartu">
    @include('pengaduan._detail')

    <h2 class="sub-judul">Beri Tanggapan</h2>

    <form method="POST" action="{{ route('petugas.pengaduan.update', $pengaduan) }}">
        @csrf
        @method('PUT')

        <div class="form-grup">
            <label for="status">Status</label>
            <select id="status" name="status">
                @foreach (['baru', 'diproses', 'selesai'] as $status)
                    <option value="{{ $status }}" {{ old('status', $pengaduan->status) === $status ? 'selected' : '' }}>
                        {{ ucfirst($status) }}
                    </option>
                @endforeach
            </select>
            @error('status') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-grup">
            <label for="tanggapan">Tanggapan</label>
            <textarea id="tanggapan" name="tanggapan">{{ old('tanggapan', $pengaduan->tanggapan) }}</textarea>
            @error('tanggapan') <div class="error">{{ $message }}</div> @enderror
        </div>

        <div class="form-aksi">
            <button type="submit" class="btn">Simpan</button>
            <a href="{{ route('petugas.pengaduan.index') }}" class="btn btn-abu">Kembali</a>
        </div>
    </form>
</div>
@endsection
