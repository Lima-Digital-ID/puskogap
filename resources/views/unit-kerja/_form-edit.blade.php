<form action="{{ route('jabatan.update', $data->id) }}" method="POST">
  @csrf
  @method('PUT')
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Jabatan</label>
      <div class="col-sm-10">
          <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror" placeholder="Nama Jabatan" value="{{old('jabatan', $data->jabatan)}}">
          @error('jabatan')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
      </div>
  </div>
  
  <button type="submit" class="btn btn-sm btn-primary"><i class="feather icon-save"></i>Simpan</button>
</form>
