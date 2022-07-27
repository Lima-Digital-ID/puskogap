<div class="container custom input-penugasan-popup" data-index='0'>
    <div class="row form-group">
        <div class="col-md-6">
            <label>Biaya</label>
            <input type="number" name="biaya[]" class="form-control @error('biaya') is-invalid @enderror" placeholder="Jumlah Biaya" value="{{old('biaya')}}">
            @error('biaya')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Jumlah Roda 4</label>
            <input type="number" name="jumlah_roda_4[]" class="form-control @error('jumlah_roda_4') is-invalid @enderror" placeholder="Jumlah Roda 4" value="{{old('jumlah_roda_4')}}">
            @error('jumlah_roda_4')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label>Jumlah Roda 2</label>
            <input type="number" name="jumlah_roda_2[]" class="form-control @error('jumlah_roda_2') is-invalid @enderror" placeholder="Jumlah Roda 2" value="{{old('jumlah_roda_2')}}">
            @error('jumlah_roda_2')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Jumlah POC</label>
            <input type="number" name="poc[]" class="form-control @error('poc') is-invalid @enderror" placeholder="Jumlah POC" value="{{old('poc')}}">
            @error('poc')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="row form-group">
        <div class="col-md-6">
            <label>Jumlah HT</label>
            <input type="number" name="jumlah_ht[]" class="form-control @error('jumlah_ht') is-invalid @enderror" placeholder="Jumlah HT" value="{{old('jumlah_ht')}}">
            @error('jumlah_ht')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Jumlah Peserta</label>
            <input type="number" name="jumlah_peserta[]" class="form-control @error('jumlah_peserta') is-invalid @enderror" placeholder="Jumlah Peserta" value="{{old('jumlah_peserta')}}">
            @error('jumlah_peserta')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-6">
            <label>Waktu Mulai</label>
            <input type="time" name="waktu_mulai[]" class="form-control waktu-mulai" onchange="getAnggota()">
        </div>
        <div class="col-md-6">
            <label>Waktu Selesai</label>
            <input type="time" name="waktu_selesai[]" class="form-control  waktu-sampai" onchange="getAnggota()">
        </div>
    </div>
    <div class="form-group">
        <div class="row">
            <div class="col-md-6">
                <div class="card card-free">
                    <div class="card-header btn-rgb-primary">
                        <h6 class="mb-0">Anggota Tidak Bertugas</h6>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for=""><b>Jabatan</b></label>
                                <select id="id_jabatan" class="form-control select2">
                                    <option value="">Semua Jabatan</option>
                                    @foreach ($jabatan as $item)
                                    <option value="{{$item->id}}">{{$item->jabatan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for=""><b>Unit Kerja</b></label>
                                <select id="id_unit_kerja" class="form-control select2">
                                    <option value="">Semua Unit Kerja</option>
                                    @foreach ($unitkerja as $item)
                                    <option value="{{$item->id}}">{{$item->unit_kerja}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="id_kompetensi_khusus"><b>Kompetensi Khusus</b></label>
                                <select id="id_kompetensi_khusus" class="form-control select2">
                                    <option value="">Semua Kompetensi Khusus</option>
                                    @foreach ($kompetensi as $item)
                                    <option value="{{$item->id}}">{{$item->kompetensi_khusus}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="font-weight-bold">Terakhir Bertugas</label>
                                <select id="terakhir_bertugas" class="form-control select2">
                                    <option value="">---Tidak Ada---</option>
                                    @for ($i = 1; $i <= 7; $i++)
                                        <option value="{{$i}}">{{$i}} Hari yang lalu </option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <br>
                        <button class="btn btn-rgb-primary" onclick="filterAnggota(event)" id="btn-filter"><span class="fa fa-filter"></span> Filter</button>
                        <hr>
                        <div class="loop-anggota-free"></div>
                        <input type="hidden" name="ketua[]" class="hidden_ketua">
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card card-bertugas" style="height:100%">
                    <div class="card-header btn-rgb-success">
                        <h6 class="mb-0">Anggota Sedang Bertugas</h6>
                    </div>
                    <div class="card-body">
                        <div class="loop-anggota-bertugas"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
