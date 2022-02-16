<form action="{{ route('kompetensi-khusus.update', $data->id) }}" method="POST">
  @csrf
  @method('PUT')

  <div class="form-group row">
      <div class="col-md-6">
        <label>Kode</label>
        <input type="text" name="kode" class="form-control @error('kode') is-invalid @enderror" placeholder="Nama Kode" value="{{old('kode', $data->kode)}}">
        @error('kode')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror          
      </div>
      <div class="col-md-6">
        <label>Kompetensi Khusus</label>
        <input type="text" name="kompetensi_khusus" class="form-control @error('kompetensi_khusus') is-invalid @enderror" placeholder="Nama Kompetensi Khusus" value="{{old('kompetensi_khusus', $data->kompetensi_khusus)}}">
        @error('kompetensi_khusus')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
        @enderror
      </div>
  </div>
  
  <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
