<form action="{{ route('user.update', $data->id) }}" method="POST">
    @csrf
    @method('put')
    <div class="form-group row">
        <div class="col-md-6">
            <label>Nama</label>
            <select name="id_anggota" id="id_anggota" class="select2 form-control" style="width: 100%;" required>
                <option value="">Pilih Anggota</option>
                @foreach ($allAng as $ang)
                    <option value="{{ $ang->id }}" {{ $data->id_anggota == $ang->id ? 'selected' : '' }}>{{ $ang->nama }}</option>
                @endforeach
            </select>
            @error('id_anggota')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Email</label>
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="Email User" value="{{ old('email', $data->email) }}">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label>Username</label>
            <input type="username" name="username" class="form-control @error('username') is-invalid @enderror"
                placeholder="Username User" value="{{ old('username', $data->username) }}">
            @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label>Level</label>
            <select name="level" id="level" class="form-control @error('level') is-invalid @enderror">
                <option value="">Pilih Level</option>
                <option value="Administrator" {{ old('level', $data->level) == 'Administrator' ? ' selected' : '' }}>Administrator</option>
                <option value="Kasat" {{ old('level', $data->level) == 'Kasat' ? ' selected' : '' }}>Kasat
                </option>
                <option value="Admin" {{ old('level', $data->level) == 'Admin' ? ' selected' : '' }}>Admin
                </option>
                <option value="Anggota" {{ old('level', $data->level) == 'Anggota' ? ' selected' : '' }}>Anggota
                </option>
            </select>
            @error('level')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>