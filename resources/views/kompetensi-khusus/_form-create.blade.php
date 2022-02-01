<form action="{{ route('kompetensi-khusus.store') }}" method="POST">
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
        <label class="col-sm-2 col-form-label">Kompetensi Khusus</label>
        <div class="col-sm-10">
            <input type="text" name="kompetensi_khusus" class="form-control @error('kompetensi_khusus') is-invalid @enderror" placeholder="Nama Kompetensi Khusus" value="{{old('kompetensi_khusus')}}">
            @error('kompetensi_khusus')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    
    <button type="submit" class="btn btn-sm btn-primary"><i class="feather icon-save"></i>Simpan</button>
</form>
