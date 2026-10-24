@extends('layouts.app')

@section('judul', 'Data ' . $label)

@section('isi')
<div class="kartu">
    <div class="kartu-atas">
        <form method="GET" action="{{ route($rute . '.index') }}" class="filter">
            <input type="text" name="cari" value="{{ request('cari') }}" placeholder="Cari nama atau email">
            <button type="submit" class="btn btn-abu">Cari</button>
        </form>

        <a href="{{ route($rute . '.create') }}" class="btn">Tambah {{ $label }}</a>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width:50px">No</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Terdaftar</th>
                <th style="width:140px">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($users as $user)
                <tr>
                    <td>{{ $users->firstItem() + $loop->index }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="aksi">
                            <a href="{{ route($rute . '.edit', $user) }}" class="btn btn-abu btn-kecil">Ubah</a>
                            <form method="POST" action="{{ route($rute . '.destroy', $user) }}"
                                  onsubmit="return confirm('Hapus akun {{ strtolower($label) }} ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-merah btn-kecil">Hapus</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="5" class="kosong">Belum ada data {{ strtolower($label) }}.</td></tr>
            @endforelse
        </tbody>
    </table>

    {{ $users->links() }}
</div>
@endsection
