<form action="{{ route('user.update', $data->id) }}" method="POST">
    @csrf
    @method('put')
    <div class="form-group row">
        <div class="col-md-6">
            <label>Nama</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="Nama User" value="{{ old('name', $data->nama) }}">
            @error('name')
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
        <div class="col-md-6">
            <label>No Whatsapp</label>
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
                placeholder="Nomor Whatsapp User" value="{{ old('phone', $data->phone) }}">
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label>Golongan</label>
            <select name="id_golongan" id="id_golongan" class="select2 form-control" style="width: 100%;" required>
                <option value="">Pilih Golongan</option>
                @foreach ($allGol as $gol)
                    <option value="{{ $gol->id }}" {{ $data->id_golongan == $gol->id ? 'selected' : '' }}>{{ $gol->pangkat }}</option>
                @endforeach
            </select>
            @error('id_golongan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Jabatan</label>
            <select name="id_jabatan" id="id_jabatan" class="select2 form-control" style="width: 100%;" required>
                <option value="">Pilih Jabatan</option>
                @foreach ($allJab as $jab)
                    <option value="{{ $jab->id }}" {{ $data->id_jabatan == $jab->id ? 'selected' : '' }}>{{ $jab->jabatan }}</option>
                @endforeach
            </select>
            @error('id_jabatan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label>Kompetensi Khusus</label>
            <select name="id_kompetensi_khusus" id="id_kompetensi_khusus" class="select2 form-control" style="width: 100%;" required>
                <option value="">Pilih Kompetensi Khusus</option>
                @foreach ($allKhs as $khs)
                    <option value="{{ $khs->id }}" {{ $data->id_kompetensi_khusus == $khs->id ? 'selected' : '' }}>{{ $khs->kompetensi_khusus }}</option>
                @endforeach
            </select>
            @error('id_kompetensi_khusus')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Unit Kerja</label>
            <select name="id_unit_kerja" id="id_unit_kerja" class="select2 form-control" style="width: 100%;" required>
                <option value="">Pilih Unit Kerja</option>
                @foreach ($allUnt as $unt)
                    <option value="{{ $unt->id }}" {{ $data->id_unit_kerja == $unt->id ? 'selected' : '' }}>{{ $unt->unit_kerja }}</option>
                @endforeach
            </select>
            @error('id_unit_kerja')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label>Jenis Pegawai</label>
            <select name="jenis_pegawai" id="jenis_pegawai" class="form-control @error('jenis_pegawai') is-invalid @enderror">
                <option value="">Pilih Jenis Pegawai</option>
                <option value="ASN" {{ old('jenis_pegawai', $data->jenis_pegawai) == 'ASN' ? ' selected' : '' }}>ASN</option>
                <option value="PTT-PK" {{ old('jenis_pegawai', $data->jenis_pegawai) == 'PTT-PK' ? ' selected' : '' }}>PTT-PK
                </option>
            </select>
            @error('jenis_pegawai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                <option value="">Pilih Jenis kelamin</option>
                <option value="L" {{ old('jenis_kelamin', $data->jenis_kelamin) == 'L' ? ' selected' : '' }}>L</option>
                <option value="P" {{ old('jenis_kelamin', $data->jenis_kelamin) == 'P' ? ' selected' : '' }}>P
                </option>
            </select>
            @error('jenis_kelamin')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
                @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label>NIP</label>
                <input type="nip" name="nip" class="form-control @error('nip') is-invalid @enderror"
                    placeholder="NIP User" value="{{ old('nip', $data->nip) }}">
                @error('nip')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
        </div>
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