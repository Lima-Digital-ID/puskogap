<form action="{{ route('jabatan.update', $data->id) }}" method="POST">
  @csrf
  @method('PUT')
  <div class="form-group row">
      <div class="col-md-6">
          <label>Jabatan</label>
          <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Nama Jabatan" value="{{old('jabatan', $data->jabatan)}}">
          @error('jabatan')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
      </div>
  </div>
  
  <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
