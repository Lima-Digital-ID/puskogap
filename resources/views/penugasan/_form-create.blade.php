<form action="{{ route('penugasan.store') }}" method="POST"  enctype="multipart/form-data" id="form-penugasan">
    @csrf
    <div class="form-group row">
        <div class="col-md-6">
            <label>Nama Kegiatan</label>
            <input type="text" name="nama_kegiatan" class="form-control @error('nama_kegiatan') is-invalid @enderror" placeholder="Nama Kegiatan" value="{{old('nama_kegiatan')}}">
            @error('nama_kegiatan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6" id="col-jenis">
            <label>Jenis Kegiatan</label>
            <select name="id_jenis_kegiatan" class="select2 form-control" style="width: 100%;">
                <option value="">Pilih Jenis Kegiatan</option>
                @foreach ($allJen as $jen)
                    <option value="{{ $jen->id }}">{{ $jen->jenis_kegiatan }}</option>
                @endforeach
            </select>
        </div>
    </div>
    
    <div class="form-group row">
        <div class="col-md-6">
            <label>Lokasi</label>
            <input type="input" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" placeholder="Nama Lokasi" value="{{old('lokasi')}}">
            @error('lokasi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>
        <div class="col-md-6">
            <label>Tamu VVIP</label>
            <input type="input" name="tamu_vvip" class="form-control @error('tamu_vvip') is-invalid @enderror" placeholder="Nama Tamu VVIP" value="{{old('tamu_vvvip')}}">
            @error('tamu_vvip')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label>Penyelenggara</label>
            <input type="text" name="penyelenggara" class="form-control @error('penyelenggara') is-invalid @enderror" placeholder="Penyelenggara" value="{{old('penyelenggara')}}">
            @error('penyelenggara')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Penanggung Jawab</label>
            <input type="input" name="penanggung_jawab" class="form-control @error('penanggung_jawab') is-invalid @enderror" placeholder="Penanggung Jawab" value="{{old('penanggung_jawab')}}">
            @error('penanggung_jawab')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror

        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label>Lampiran</label>
            <input type="file" id="lampiran" name="lampiran" class="form-control @error('lampiran') is-invalid @enderror" placeholder="Lampiran" value="{{old('lampiran')}}">
            @error('penanggung_jawab')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Status</label>
            <select name="status" id="status" class="form-control @error('status') is-invalid @enderror">
                <option value="">Pilih Level</option>
                <option value="Rencana" {{ old('status') == 'Rencana' ? ' selected' : '' }}>Rencana</option>
                <option value="Pelaksanaan" {{ old('status') == 'Pelaksanaan' ? ' selected' : '' }}>Pelaksanaan</option>
                <option value="Selesai" {{ old('status') == 'Selesai' ? ' selected' : '' }}>Selesai</option>
                <option value="Batal" {{ old('status') == 'Batal' ? ' selected' : '' }}>Batal</option>
            </select>
            @error('status')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label>Keterangan</label>
            <input type="input" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" placeholder="keterangan" value="{{old('keterangan')}}">
            @error('keterangan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Tanggal Kegiatan</label>
            <div class="input-group input-group-tanggal">
                <input type="text" id="pilih-tanggal" class="form-control" placeholder="Belum ada tanggal yang dipilih" name="tanggal_kegiatan" readonly>
                <div class="input-group-append">
                    <button type="button" class="btn btn-success btn-tanggal"><span class="fa fa-calendar"></span> Jadwalkan</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modalTanggal" tabindex="-1" role="dialog" aria-labelledby="modalTanggalLabel" aria-hidden="true">
        <div class="modal-dialog  modal-tanggal" role="document">
          <div class="modal-content">
            <div class="modal-header bg-success container custom">
              <h5 class="modal-title" id="modalTanggalLabel" style="color:white">Jadwal Penugasan</h5>
            </div>
            <div class="modal-body">
                <div class="container custom">
                    <div id="list-tanggal" class="d-inline">
                    </div>
                    {{-- <button class="btn btn-success btn-add-tanggal" type="button" onclick="newItemTanggal()"><span class="fa fa-plus"></span></button> --}}
                    <hr>
                </div>
                @include('penugasan.input-popup')
            </div>
            <div class="modal-footer">
                <div class="container custom">
                    <div class="row form-group justify-content-end">
                        <div class="col text-right">
                            <div class="btn-group" role="group" aria-label="Basic example">
                                <button type="button" class="btn btn-default reset-popup"><i class="fa fa-times"></i> Reset</button>
                                <button type="button" class="btn btn-primary" onclick="save(true)"><i class="fa fa-save"></i> Simpan dan Tambah Tanggal Baru</button>
                                <button type="button" class="btn btn-success" onclick="save()"><i class="fa fa-save"></i> Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
          </div>
        </div>
    </div>
    <br>
    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
