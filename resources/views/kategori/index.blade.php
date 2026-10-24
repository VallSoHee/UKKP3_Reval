@extends('layouts.app')

@section('judul', 'Data Kategori')

@section('isi')
<div class="kartu">
    <div class="kartu-atas">
        <a href="{{ route('kategori.create') }}" class="btn">Tambah Kategori</a>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:50px">No</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th style="width:140px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($kategoris as $kategori)
                <tr>
                    <td>{{ $kategoris->firstItem() + $loop->index }}</td>
                    <td>{{ $kategori->nama }}</td>
                    <td>{{ $kategori->deskripsi ?? '-' }}</td>
                    <td>
                        <div class="aksi">
                            <a href="{{ route('kategori.edit', $kategori) }}" class="btn btn-abu btn-kecil">Ubah</a>
                            <form method="POST" action="{{ route('kategori.destroy', $kategori) }}"
                                  onsubmit="return confirm('Hapus kategori ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-merah btn-kecil">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="4" class="kosong">Belum ada kategori.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $kategoris->links() }}
</div>
@endsection
