@extends('layouts.app')

@section('judul', 'Kelola Pengaduan')

@section('isi')
<div class="kartu">
    <div class="kartu-atas">
        <form method="GET" action="{{ route('petugas.pengaduan.index') }}" class="filter">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau email">
            <select name="status">
                <option value="">Semua status</option>
                @foreach (['baru', 'diproses', 'selesai'] as $status)
                    <option value="{{ $status }}" {{ request('status') === $status ? 'selected' : '' }}>{{ ucfirst($status) }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-abu">Cari</button>
        </form>
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
                <th style="width:170px">Aksi</th>
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
                    <td>{{ \Illuminate\Support\Str::limit($pengaduan->aduan, 50) }}</td>
                    <td>{{ $pengaduan->lampirans_count }}</td>
                    <td><span class="badge badge-{{ $pengaduan->status }}">{{ ucfirst($pengaduan->status) }}</span></td>
                    <td>{{ $pengaduan->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="aksi">
                            <a href="{{ route('petugas.pengaduan.show', $pengaduan) }}" class="btn btn-abu btn-kecil">Tanggapi</a>
                            <form method="POST" action="{{ route('petugas.pengaduan.destroy', $pengaduan) }}"
                                  onsubmit="return confirm('Hapus pengaduan ini beserta foto buktinya?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-merah btn-kecil">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="10" class="kosong">Tidak ada pengaduan.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $pengaduans->links() }}
</div>
@endsection
