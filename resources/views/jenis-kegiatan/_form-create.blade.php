<form action="{{ route('jenis-kegiatan.store') }}" method="POST">
    @csrf
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Kode</label>
        <div class="col-sm-10">
            <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="Kode" value="{{old('kode')}}">
            @error('kode')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Jenis Kegiatan</label>
        <div class="col-sm-10">
            <input type="text" name="jenis_kegiatan" class="form-control @error('jenis_kegiatan') is-invalid @enderror" placeholder="Nama Jenis Kegiatan" value="{{old('jenis_kegiatan')}}">
            @error('jenis_kegiatan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
        <div class="form-group row">
        <label class="col-sm-2 col-form-label">Jenis</label>
        <div class="col-sm-10">
            <select name="jenis" id="jenis" class="form-control" style="width: 100%;" required>
                <option value="">Pilih Jenis</option>
                <option value="PUSKOGAP">PUSKOGAP</option>
                <option value="TUSI">TUSI</option>
            </select>
            @error('jenis')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    
    <button type="submit" class="btn btn-sm btn-primary"><i class="feather icon-save"></i>Simpan</button>
</form>