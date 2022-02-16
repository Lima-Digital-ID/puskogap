<form action="{{ route('golongan.update', $data->id) }}" method="POST">
  @csrf
  @method('PUT')
  <div class="form-group row">
      <label class="col-sm-2 col-form-label">Pangkat</label>
      <div class="col-sm-10">
          <input type="text" name="pangkat" class="form-control @error('pangkat') is-invalid @enderror" placeholder="Nama Pangkat" value="{{old('pangkat', $data->pangkat)}}">
          @error('pangkat')
              <div class="invalid-feedback">
                  {{ $message }}
              </div>
          @enderror
      </div>
  </div>
  
  <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
