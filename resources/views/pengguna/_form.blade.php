<div class="form-grup">
    <label for="name">Nama</label>
    <input type="text" id="name" name="name" value="{{ old('name', $user->name ?? '') }}">
    @error('name') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-grup">
    <label for="email">Email</label>
    <input type="email" id="email" name="email" value="{{ old('email', $user->email ?? '') }}">
    @error('email') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-grup">
    <label for="password">Password</label>
    <input type="password" id="password" name="password" autocomplete="new-password">
    <div class="bantuan">
        @isset($user)
            Kosongkan jika password tidak ingin diganti. Minimal 6 karakter.
        @else
            Minimal 6 karakter.
        @endisset
    </div>
    @error('password') <div class="error">{{ $message }}</div> @enderror
</div>

<div class="form-aksi">
    <button type="submit" class="btn">Simpan</button>
    <a href="{{ route($rute . '.index') }}" class="btn btn-abu">Batal</a>
</div>
