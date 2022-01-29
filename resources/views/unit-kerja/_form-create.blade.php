<form action="{{ route('unit-kerja.store') }}" method="POST">
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
        <label class="col-sm-2 col-form-label">Unit Kerja</label>
        <div class="col-sm-10">
            <input type="text" name="unit_kerja" class="form-control @error('unit_kerja') is-invalid @enderror" placeholder="Nama unit kerja" value="{{old('unit_kerja')}}">
            @error('unit_kerja')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    
    <button type="submit" class="btn btn-sm btn-primary"><i class="feather icon-save"></i>Simpan</button>
</form>
