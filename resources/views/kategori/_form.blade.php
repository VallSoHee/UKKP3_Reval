<div class="form-grup">
    <label for="nama">Nama Kategori</label>
    <input type="text" id="nama" name="nama" value="{{ old('nama', $kategori->nama ?? '') }}">
    @error('nama') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-grup">
    <label for="deskripsi">Deskripsi (opsional)</label>
    <textarea id="deskripsi" name="deskripsi">{{ old('deskripsi', $kategori->deskripsi ?? '') }}</textarea>
    @error('deskripsi') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-aksi">
    <button type="submit" class="btn">Simpan</button>
    <a href="{{ route('kategori.index') }}" class="btn btn-abu">Batal</a>
</div>
