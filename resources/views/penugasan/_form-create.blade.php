<form action="{{ route('penugasan.store') }}" method="POST"  enctype="multipart/form-data">
    @csrf
    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Nama Kegiatan</label>
        <div class="col-sm-10">
            <input type="text" name="nama_kegiatan" class="form-control @error('nama_kegiatan') is-invalid @enderror" placeholder="Nama Kegiatan" value="{{old('nama_kegiatan')}}">
            @error('nama_kegiatan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Jenis Kegiatan</label>
        <div class="col-sm-10">
            <select name="id_jenis_kegiatan" class="js-example-basic-single" style="width: 100%;" required>
                <option value="0">Pilih Jenis Kegiatan</option>
                @foreach ($allJen as $jen)
                    <option value="{{ $jen->id }}">{{ $jen->jenis_kegiatan }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Waktu Mulai</label>
        <div class="col-sm-10">
            <input type="datetime-local" name="waktu_mulai" class="form-control ambilAnggota @error('waktu_mulai') is-invalid @enderror" placeholder="Nama waktu_mulai" value="{{old('waktu_mulai')}}">
            @error('waktu_mulai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Waktu Selesai</label>
        <div class="col-sm-10">
            <input type="datetime-local" name="waktu_selesai" class="form-control ambilAnggota @error('waktu_selesai') is-invalid @enderror" placeholder="Nama waktu_selesai" value="{{old('waktu_selesai')}}">
            @error('waktu_selesai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Lokasi</label>
        <div class="col-sm-10">
            <input type="input" name="lokasi" class="form-control @error('lokasi') is-invalid @enderror" placeholder="Nama Lokasi" value="{{old('lokasi')}}">
            @error('lokasi')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <input type="hidden" name="ketua" id="ketua">
    {{-- <div class="form-group row" id="ketua">
        <label class="col-sm-2 col-form-label">Ketua</label>
        <div class="col-sm-10">
            <select name="ketua" class="js-example-basic-single" style="width: 100%;">
                <option value="">Pilih Ketua</option>
                <option value="1">Pilih Aku</option>
            </select>
        </div>
    </div> --}}

    <div class="form-group row mb-5">
        <div class="col-md-12">
            <div class="form-control">
                <div class="row">
                    <div class="col-md-7">
                        <div class="bg-light p-3">
                            <h5 class="font-weight-bold">Anggota Tidak Bertugas</h5>
                            <hr>
                            <div class="row">
                                <div class="col-md-4">
                                    <label for=""><b>Jabatan</b></label>
                                    <select id="id_jabatan" class="form-control js-example-basic-single">
                                        <option value="">Semua Jabatan</option>
                                        @foreach ($jabatan as $item)
                                        <option value="{{$item->id}}">{{$item->jabatan}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for=""><b>Unit Kerja</b></label>
                                    <select id="id_unit_kerja" class="form-control js-example-basic-single">
                                        <option value="">Semua Unit Kerja</option>
                                        @foreach ($kompetensi as $item)
                                        <option value="{{$item->id}}">{{$item->kompetensi_khusus}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-4">
                                    <label for="id_kompetensi_khusus"><b>Kompetensi Khusus</b></label>
                                    <select id="id_kompetensi_khusus" class="form-control js-example-basic-single">
                                        <option value="">Semua Kompetensi Khusus</option>
                                        @foreach ($unitkerja as $item)
                                            <option value="{{$item->id}}">{{$item->unit_kerja}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <br>
                            <button class="btn btn-primary btn-sm" id="btn-filter"><span class="fa fa-filter"></span> Filter</button>
                            <hr>
                            <div class="loop-anggota-free">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-5">
                        <div class="bg-light p-3">
                            <h5 class="font-weight-bold">Anggota Bertugas</h5>
                            <hr>
                            <div class="loop-anggota-bertugas">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- <label class="col-sm-2 col-form-label">Anggota Bertugas</label>
        <div class="col-sm-4">
            <select name="anggota_not_free[]" class="js-example-basic-single" multiple="multiple" style="width: 100%;">
                <option value="1">Pilih Anggota Bertugas</option>
                <option value="2">Pilih Anggota Bertugas</option>
                <option value="4">Pilih Anggota Bertugas</option>
            </select>
        </div>
        <label class="col-sm-2 col-form-label">Anggota Kosong</label>
        <div class="col-sm-4">
            <select name="anggota_free" class="js-example-basic-single" multiple="multiple" style="width: 100%;">
                <option value="46">Pilih Anggota Kosong</option>
                <option value="45">Pilih Anggota Kosong</option>
                <option value="44">Pilih Anggota Kosong</option>
            </select>
        </div> --}}
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Tamu VVIP</label>
        <div class="col-sm-10">
            <input type="input" name="tamu_vvip" class="form-control @error('tamu_vvip') is-invalid @enderror" placeholder="Nama Tamu VVIP" value="{{old('tamu_vvip')}}">
            @error('tamu_vvip')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Biaya</label>
        <div class="col-sm-10">
            <input type="number" name="biaya" class="form-control @error('biaya') is-invalid @enderror" placeholder="Jumlah Biaya" value="{{old('biaya')}}">
            @error('biaya')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Jumlah Roda 4</label>
        <div class="col-sm-10">
            <input type="number" name="jumlah_roda_4" class="form-control @error('jumlah_roda_4') is-invalid @enderror" placeholder="Jumlah Roda 4" value="{{old('jumlah_roda_4')}}">
            @error('jumlah_roda_4')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Jumlah Roda 2</label>
        <div class="col-sm-10">
            <input type="number" name="jumlah_roda_2" class="form-control @error('jumlah_roda_2') is-invalid @enderror" placeholder="Jumlah Roda 2" value="{{old('jumlah_roda_2')}}">
            @error('jumlah_roda_2')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Jumlah POC</label>
        <div class="col-sm-10">
            <input type="number" name="poc" class="form-control @error('poc') is-invalid @enderror" placeholder="Jumlah POC" value="{{old('poc')}}">
            @error('poc')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Jumlah HT</label>
        <div class="col-sm-10">
            <input type="number" name="jumlah_ht" class="form-control @error('jumlah_ht') is-invalid @enderror" placeholder="Jumlah HT" value="{{old('jumlah_ht')}}">
            @error('jumlah_ht')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Penyelenggara</label>
        <div class="col-sm-10">
            <input type="text" name="penyelenggara" class="form-control @error('penyelenggara') is-invalid @enderror" placeholder="Penyelenggara" value="{{old('penyelenggara')}}">
            @error('penyelenggara')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Jumlah Peserta</label>
        <div class="col-sm-10">
            <input type="number" name="jumlah_peserta" class="form-control @error('jumlah_peserta') is-invalid @enderror" placeholder="Jumlah Peserta" value="{{old('jumlah_peserta')}}">
            @error('jumlah_peserta')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Penanggung Jawab</label>
        <div class="col-sm-10">
            <input type="input" name="penanggung_jawab" class="form-control @error('penanggung_jawab') is-invalid @enderror" placeholder="Penanggung Jawab" value="{{old('penanggung_jawab')}}">
            @error('penanggung_jawab')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Lampiran</label>
        <div class="col-sm-10">
            <input type="file" name="lampiran" class="form-control @error('lampiran') is-invalid @enderror" placeholder="Lampiran" value="{{old('lampiran')}}">
            @error('penanggung_jawab')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Status</label>
        <div class="col-sm-10">
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

    <div class="form-group row">
        <label class="col-sm-2 col-form-label">Keterangan</label>
        <div class="col-sm-10">
            <input type="input" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror" placeholder="keterangan" value="{{old('keterangan')}}">
            @error('keterangan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    
    <button type="submit" class="btn btn-sm btn-primary"><i class="feather icon-save"></i>Simpan</button>
</form>
