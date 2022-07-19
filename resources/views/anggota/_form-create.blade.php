<form action="{{ route('anggota.store') }}" method="POST">
    @csrf
    <div class="form-group row">
        <div class="col-md-6">
            <label>Nama</label>
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
                placeholder="Nama Anggota" value="{{ old('name') }}">
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Golongan</label>
            <select name="id_golongan" id="id_golongan" class="select2 form-control" style="width: 100%;" required>
                <option value="">Pilih Golongan</option>
                @foreach ($allGol as $gol)
                    <option value="{{ $gol->id }}" {{ old('id_golongan') == $gol->id ? ' selected' : '' }}>{{ $gol->pangkat }}</option>
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
        <div class="col-md-6">
            <label>Jabatan</label>
            <select name="id_jabatan" id="id_jabatan" class="select2 form-control" style="width: 100%;" required>
                <option value="">Pilih Jabatan</option>
                @foreach ($allJab as $jab)
                    <option value="{{ $jab->id }}" {{ old('id_jabatan') == $jab->id ? ' selected' : '' }}>{{ $jab->jabatan }}</option>
                @endforeach
            </select>
            @error('id_jabatan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Kompetensi Khusus</label>
            <select name="id_kompetensi_khusus[]" id="id_kompetensi_khusus" class="select2 form-control" style="width: 100%;" multiple="multiple" required>
                <option value="">Pilih Kompetensi Khusus</option>
                @foreach ($allKhs as $khs)
                    <option value="{{ $khs->id }}" {{ old('id_kompetensi_khusus') == $khs->id ? ' selected' : '' }}>{{ $khs->kompetensi_khusus }}</option>
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
        <div class="col-md-6">
            <label>Unit Kerja</label>
            <select name="id_unit_kerja" id="id_unit_kerja" class="select2 form-control" style="width: 100%;" required>
                <option value="">Pilih Unit Kerja</option>
                @foreach ($allUnt as $unt)
                    <option value="{{ $unt->id }}" {{ old('id_unit_kerja') == $unt->id ? ' selected' : '' }}>{{ $unt->unit_kerja }}</option>
                @endforeach
            </select>
            @error('id_unit_kerja')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Jenis Pegawai</label>
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
        <div class="col-md-6">
            <label>Jenis Kelamin</label>
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
        <div class="col-md-6">
            <label>NIP</label>
            <input type="nip" name="nip" class="form-control @error('nip') is-invalid @enderror"
                placeholder="NIP anggota" value="{{ old('nip') }}">
            @error('nip')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <div class="col-md-6">
            <label>No Handphone</label>
            <input type="phone" name="phone" class="form-control @error('phone') is-invalid @enderror"
                placeholder="Phone anggota" value="{{ old('phone') }}" maxlength="15">
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
