<div class="form-grup">
    <label for="nama">Nama Customer</label>
    <input type="text" id="nama" name="nama" value="{{ old('nama') }}">
    @error('nama') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-grup">
    <label for="nomor_meja">Nomor Meja</label>
    <select id="nomor_meja" name="nomor_meja">
        <option value="">- Pilih nomor meja -</option>
        @for ($i = 1; $i <= ($jumlahMeja ?? 20); $i++)
            <option value="{{ $i }}" {{ (string) old('nomor_meja') === (string) $i ? 'selected' : '' }}>{{ $i }}</option>
        @endfor
    </select>
    <div class="bantuan">Pilih nomor meja tempat Anda duduk.</div>
    @error('nomor_meja') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-grup">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="{{ old('email') }}">
    @error('email') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-grup">
    <label for="no_hp">No HP</label>
    <input type="text" id="no_hp" name="no_hp" maxlength="14" value="{{ old('no_hp') }}">
    <div class="bantuan">Dipakai untuk konfirmasi atau tindak lanjut. Maksimal 14 angka.</div>
    @error('no_hp') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-grup">
    <label for="kategori_id">Kategori</label>
    <select id="kategori_id" name="kategori_id">
        <option value="">- Pilih kategori -</option>
        @foreach ($kategoris as $kategori)
            <option value="{{ $kategori->id }}" {{ (string) old('kategori_id') === (string) $kategori->id ? 'selected' : '' }}>
                {{ $kategori->nama }}
            </option>
        @endforeach
        <option value="lainnya" {{ old('kategori_id') === 'lainnya' ? 'selected' : '' }}>Lainnya (isi manual)</option>
    </select>
    @error('kategori_id') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-grup" id="kategori-manual-box" style="display:none">
    <label for="kategori_manual">Kategori Manual</label>
    <input type="text" id="kategori_manual" name="kategori_manual" value="{{ old('kategori_manual') }}">
    @error('kategori_manual') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-grup">
    <label for="aduan">Isi Aduan</label>
    <textarea id="aduan" name="aduan">{{ old('aduan') }}</textarea>
    @error('aduan') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-grup">
    <label>Foto Bukti</label>

    <div id="foto-list">
        <div class="foto-baris">
            <input type="file" name="foto[]" accept="image/png,image/jpeg">
            <button type="button" class="btn btn-abu btn-kecil btn-hapus">Hapus</button>
        </div>
    </div>

    <button type="button" id="tambah-foto" class="btn btn-kecil" disabled>+ Tambah Foto</button>
    <div class="bantuan">Format jpg, jpeg, atau png. Maksimal 2 MB per foto. Pilih foto dulu, lalu tekan + untuk menambah foto lain.</div>
    @error('foto.*') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-aksi">
    <button type="submit" class="btn">Kirim Pengaduan</button>
    <a href="{{ route('pengaduan.index') }}" class="btn btn-abu">Batal</a>
</div>

<script>
    // Tampilkan input kategori manual hanya kalau memilih "Lainnya"
    const pilihKategori = document.getElementById('kategori_id');
    const boxManual = document.getElementById('kategori-manual-box');

    function aturKategoriManual() {
        boxManual.style.display = pilihKategori.value === 'lainnya' ? 'block' : 'none';
    }
    pilihKategori.addEventListener('change', aturKategoriManual);
    aturKategoriManual();

    // Upload foto banyak: tombol + aktif setelah input terakhir terisi
    const daftarFoto = document.getElementById('foto-list');
    const tombolTambah = document.getElementById('tambah-foto');

    function aturTombolTambah() {
        const semuaInput = daftarFoto.querySelectorAll('input[type=file]');
        const terakhir = semuaInput[semuaInput.length - 1];
        tombolTambah.disabled = terakhir.files.length === 0;
    }

    function tambahBaris() {
        const baris = document.createElement('div');
        baris.className = 'foto-baris';
        baris.innerHTML =
            '<input type="file" name="foto[]" accept="image/png,image/jpeg">' +
            '<button type="button" class="btn btn-abu btn-kecil btn-hapus">Hapus</button>';
        daftarFoto.appendChild(baris);
        aturTombolTambah();
    }

    tombolTambah.addEventListener('click', tambahBaris);

    daftarFoto.addEventListener('change', aturTombolTambah);

    daftarFoto.addEventListener('click', function (e) {
        if (!e.target.classList.contains('btn-hapus')) return;

        e.target.parentElement.remove();

        // Selalu sisakan minimal satu input
        if (daftarFoto.children.length === 0) {
            tambahBaris();
        } else {
            aturTombolTambah();
        }
    });
</script>
