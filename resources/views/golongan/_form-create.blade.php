<form action="{{ route('golongan.store') }}" method="POST">
    @csrf
    <div class="form-group row col-md-6">
        <label>Pangkat</label>
        <input type="text" name="pangkat" class="form-control @error('pangkat') is-invalid @enderror" placeholder="Nama Pangkat" value="{{old('pangkat')}}">
        @error('pangkat')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
    </div>

    
    <button type="submit" class="btn btn-sm btn-primary"><i class="feather icon-save"></i>Simpan</button>
</form>
