<form action="{{ route('jenis-kegiatan.store') }}" method="POST">
    @csrf
    <div class="form-group row">
        <div class="col-md-6">
            <label>Kode</label>
            <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="Kode" value="{{old('kode')}}">
            @error('kode')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Jenis Kegiatan</label>
            <input type="text" name="jenis_kegiatan" class="form-control @error('jenis_kegiatan') is-invalid @enderror" placeholder="Nama Jenis Kegiatan" value="{{old('jenis_kegiatan')}}">
            @error('jenis_kegiatan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <label>Jenis</label>
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
    
    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
