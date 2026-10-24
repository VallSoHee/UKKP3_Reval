{{-- Detail pengaduan, dipakai di halaman customer dan petugas --}}
<dl class="detail">
    <dt>Nama Customer</dt>
    <dd>{{ $pengaduan->nama }}</dd>

    <dt>Nomor Meja</dt>
    <dd>{{ $pengaduan->nomor_meja ?? '-' }}</dd>

    <dt>Email</dt>
    <dd>{{ $pengaduan->email }}</dd>

    <dt>No HP</dt>
    <dd>{{ $pengaduan->no_hp }}</dd>

    <dt>Kategori</dt>
    <dd>{{ $pengaduan->nama_kategori }}</dd>

    <dt>Status</dt>
    <dd><span class="badge badge-{{ $pengaduan->status }}">{{ ucfirst($pengaduan->status) }}</span></dd>

    <dt>Tanggal</dt>
    <dd>{{ $pengaduan->created_at->format('d/m/Y H:i') }}</dd>

    <dt>Isi Aduan</dt>
    <dd>{{ $pengaduan->aduan }}</dd>

    <dt>Tanggapan</dt>
    <dd>{{ $pengaduan->tanggapan ?? 'Belum ada tanggapan.' }}</dd>

    <dt>Foto Bukti</dt>
    <dd>
        @if ($pengaduan->lampirans->count())
            <div class="foto-lama">
                @foreach ($pengaduan->lampirans as $foto)
                    <a href="{{ route('lampiran.tampil', $foto) }}" target="_blank" class="foto-item">
                        <img src="{{ route('lampiran.tampil', $foto) }}" alt="{{ $foto->nama_asli }}">
                    </a>
                @endforeach
            </div>
        @else
            Tidak ada foto.
        @endif
    </dd>
</dl>
