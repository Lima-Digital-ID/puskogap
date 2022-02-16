<form action="{{ route('jenis-kegiatan.update', $data->id) }}" method="POST">
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
        <label>Jenis Kegiatan</label>
        <input type="text" name="jenis_kegiatan" class="form-control @error('jenis_kegiatan') is-invalid @enderror" placeholder="Nama Jenis Kegiatan" value="{{old('jenis_kegiatan', $data->jenis_kegiatan)}}"> @error('jenis_kegiatan')
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
                <option value="{{ $data->id }}" selected>{{ $data->jenis }}</option>
            </select>
            @error('jenis')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
  </div>
  
  <button type="submit" class="btn btn-sm btn-primary"><i class="feather icon-save"></i>Simpan</button>
</form>
