<form action="{{ route('unit-kerja.store') }}" method="POST">
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
            <label>Unit Kerja</label>
            <input type="text" name="unit_kerja" class="form-control @error('unit_kerja') is-invalid @enderror" placeholder="Nama unit kerja" value="{{old('unit_kerja')}}">
            @error('unit_kerja')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    
    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
