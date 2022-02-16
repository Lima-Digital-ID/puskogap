<form action="{{ route('jabatan.store') }}" method="POST">
    @csrf
    <div class="form-group row col-md-6">
        <label>Jabatan</label>
        <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Nama Jabatan" value="{{old('jabatan')}}">
        @error('jabatan')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    
    <button type="submit" class="btn btn-sm btn-primary"><i class="feather icon-save"></i>Simpan</button>
</form>
