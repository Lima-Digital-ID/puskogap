<form action="{{ route('user.store') }}" method="POST">
    @csrf
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Nama</label>
        <div class="col-sm-10">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="Nama User" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Email</label>
        <div class="col-sm-10">
            <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                placeholder="Email User" value="{{ old('email') }}">
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Username</label>
        <div class="col-sm-10">
            <input type="username" name="username" class="form-control @error('username') is-invalid @enderror"
                placeholder="Username User" value="{{ old('username') }}">
            @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

        <div class="form-group row">
        <label class="col-sm-2 col-form-label">Golongan</label>
        <div class="col-sm-10">
            <select name="id_golongan" id="id_golongan" class="js-example-basic-single" style="width: 100%;" required>
                <option value="">Pilih Golongan</option>
                @foreach ($allGol as $gol)
                    <option value="{{ $gol->id }}">{{ $gol->pangkat }}</option>
                @endforeach
            </select>
            @error('id_golongan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

        <div class="form-group row">
        <label class="col-sm-2 col-form-label">Jabatan</label>
        <div class="col-sm-10">
            <select name="id_jabatan" id="id_jabatan" class="js-example-basic-single" style="width: 100%;" required>
                <option value="">Pilih Jabatan</option>
                @foreach ($allJab as $jab)
                    <option value="{{ $jab->id }}">{{ $jab->jabatan }}</option>
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
        <label class="col-sm-2 col-form-label">Kompetensi Khusus</label>
        <div class="col-sm-10">
            <select name="id_kompetensi_khusus" id="id_kompetensi_khusus" class="js-example-basic-single" style="width: 100%;" required>
                <option value="">Pilih Kompetensi Khusus</option>
                @foreach ($allKhs as $khs)
                    <option value="{{ $khs->id }}">{{ $khs->kompetensi_khusus }}</option>
                @endforeach
            </select>
            @error('id_kompetensi_khusus')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

        <div class="form-group row">
        <label class="col-sm-2 col-form-label">Unit Kerja</label>
        <div class="col-sm-10">
            <select name="id_unit_kerja" id="id_unit_kerja" class="js-example-basic-single" style="width: 100%;" required>
                <option value="">Pilih Unit Kerja</option>
                @foreach ($allUnt as $unt)
                    <option value="{{ $unt->id }}">{{ $unt->unit_kerja }}</option>
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
        <label class="col-sm-2 col-form-label">Jenis Pegawai</label>
        <div class="col-sm-10">
            <select name="jenis_pegawai" id="jenis_pegawai" class="form-control @error('jenis_pegawai') is-invalid @enderror">
                <option value="">Pilih Jenis Pegawai</option>
                <option value="ASN" {{ old('jenis_pegawai') == 'ASN' ? ' selected' : '' }}>ASN</option>
                <option value="PTT-PK" {{ old('jenis_pegawai') == 'PTT-PK' ? ' selected' : '' }}>PTT-PK
                </option>
            </select>
            @error('jenis_pegawai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Jenis Kelamin</label>
        <div class="col-sm-10">
            <select name="jenis_kelamin" id="jenis_kelamin" class="form-control @error('jenis_kelamin') is-invalid @enderror">
                <option value="">Pilih Jenis kelamin</option>
                <option value="L" {{ old('jenis_kelamin') == 'L' ? ' selected' : '' }}>L</option>
                <option value="P" {{ old('jenis_kelamin') == 'P' ? ' selected' : '' }}>P
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
        <label class="col-sm-2 col-form-label">NIP</label>
        <div class="col-sm-10">
            <input type="nip" name="nip" class="form-control @error('nip') is-invalid @enderror"
                placeholder="NIP User" value="{{ old('nip') }}">
            @error('nip')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Level</label>
        <div class="col-sm-10">
            <select name="level" id="level" class="form-control @error('level') is-invalid @enderror">
                <option value="">Pilih Level</option>
                <option value="Administrator" {{ old('level') == 'Administrator' ? ' selected' : '' }}>Administrator</option>
                <option value="Kasat" {{ old('level') == 'Kasat' ? ' selected' : '' }}>Kasat
                </option>
                <option value="Admin" {{ old('level') == 'Admin' ? ' selected' : '' }}>Admin
                </option>
                <option value="Anggota" {{ old('level') == 'Anggota' ? ' selected' : '' }}>Anggota
                </option>
            </select>
            @error('level')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>


    <button type="submit" class="btn btn-sm btn-primary"><i class="feather icon-save"></i>Simpan</button>
</form>