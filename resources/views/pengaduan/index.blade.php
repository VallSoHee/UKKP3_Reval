@extends('layouts.app')

@section('judul', 'Data Pengaduan')

@section('isi')
<div class="kartu">
    <div class="kartu-atas">
        <form method="GET" action="{{ route('pengaduan.index') }}" class="filter">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau email">
            <button type="submit" class="btn btn-abu">Cari</button>
        </form>

        <a href="{{ route('pengaduan.create') }}" class="btn">Tambah Pengaduan</a>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:50px">No</th>
                <th>Customer</th>
                <th>Meja</th>
                <th>No HP</th>
                <th>Kategori</th>
                <th>Aduan</th>
                <th>Foto</th>
                <th>Status</th>
                <th>Tanggal</th>
                <th style="width:100px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($pengaduans as $pengaduan)
                <tr>
                    <td>{{ $pengaduans->firstItem() + $loop->index }}</td>
                    <td>
                        {{ $pengaduan->nama }}<br>
                        <span class="bantuan">{{ $pengaduan->email }}</span>
                    </td>
                    <td>{{ $pengaduan->nomor_meja ?? '-' }}</td>
                    <td>{{ $pengaduan->no_hp }}</td>
                    <td>{{ $pengaduan->nama_kategori }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($pengaduan->aduan, 60) }}</td>
                    <td>{{ $pengaduan->lampirans_count }}</td>
                    <td><span class="badge badge-{{ $pengaduan->status }}">{{ ucfirst($pengaduan->status) }}</span></td>
                    <td>{{ $pengaduan->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="aksi">
                            <a href="{{ route('pengaduan.show', $pengaduan) }}" class="btn btn-abu btn-kecil">Detail</a>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="10" class="kosong">Belum ada pengaduan.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $pengaduans->links() }}
</div>
@endsection
