<div class="container custom input-penugasan-popup {{$index==0 ? 'active' : ''}}" data-index='{{$index}}'>
    <input type="hidden" class="id_waktu_penugasan" name="id_waktu_penugasan[]" value="{{$item['id']}}">
    <div class="row form-group">
        <div class="col-md-6">
            <label>Biaya</label>
            <input type="number" name="biaya[]" class="form-control @error('biaya') is-invalid @enderror" placeholder="Jumlah Biaya" value="{{old('biaya',$item['biaya'])}}">
            @error('biaya')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Jumlah Roda 4</label>
            <input type="number" name="jumlah_roda_4[]" class="form-control @error('jumlah_roda_4') is-invalid @enderror" placeholder="Jumlah Roda 4" value="{{old('jumlah_roda_4',$item['jumlah_roda_4'])}}">
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
            <input type="number" name="jumlah_roda_2[]" class="form-control @error('jumlah_roda_2') is-invalid @enderror" placeholder="Jumlah Roda 2" value="{{old('jumlah_roda_2',$item['jumlah_roda_2'])}}">
            @error('jumlah_roda_2')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Jumlah POC</label>
            <input type="number" name="poc[]" class="form-control @error('poc') is-invalid @enderror" placeholder="Jumlah POC" value="{{old('poc',$item['poc'])}}">
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
            <input type="number" name="jumlah_ht[]" class="form-control @error('jumlah_ht') is-invalid @enderror" placeholder="Jumlah HT" value="{{old('jumlah_ht',$item['jumlah_ht'])}}">
            @error('jumlah_ht')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class="col-md-6">
            <label>Jumlah Peserta</label>
            <input type="number" name="jumlah_peserta[]" class="form-control @error('jumlah_peserta') is-invalid @enderror" placeholder="Jumlah Peserta" value="{{old('jumlah_peserta',$item['jumlah_peserta'])}}">
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
            <input type="time" name="waktu_mulai[]" value="{{old('waktu_mulai',$item['waktu_mulai'])}}" class="form-control waktu-mulai" onchange="getAnggota()">
        </div>
        <div class="col-md-6">
            <label>Waktu Selesai</label>
            <input type="time" name="waktu_selesai[]" value="{{old('waktu_selesai',$item['waktu_selesai'])}}" class="form-control  waktu-sampai" onchange="getAnggota()">
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
                                    @foreach ($jabatan as $data)
                                    <option value="{{$data->id}}">{{$data->jabatan}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for=""><b>Unit Kerja</b></label>
                                <select id="id_unit_kerja" class="form-control select2">
                                    <option value="">Semua Unit Kerja</option>
                                    @foreach ($unitkerja as $data)
                                    <option value="{{$data->id}}">{{$data->unit_kerja}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="id_kompetensi_khusus"><b>Kompetensi Khusus</b></label>
                                <select id="id_kompetensi_khusus" class="form-control select2">
                                    <option value="">Semua Kompetensi Khusus</option>
                                    @foreach ($kompetensi as $data)
                                    <option value="{{$data->id}}">{{$data->kompetensi_khusus}}</option>
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
                        <div class="loop-anggota-free">
                            @php
                                $loopAnggota = count($item['detail_anggota']) - 1;
                                $ketua = $item['detail_anggota'][$loopAnggota]['anggota']['id'];
                            @endphp
                            @for ($i=0;$i<$loopAnggota;$i++)
                                <div class="select-anggota mb-2 checked {{$item['detail_anggota'][$loopAnggota]['anggota']['id']==$item['detail_anggota'][$i]['anggota']['id'] ? 'selected-ketua' : ''}}">
                                    <label class='check-anggota' for="free{{$index}}{{$i}}">
                                        <input type="checkbox" id="free{{$index}}{{$i}}" name="id_user[{{$index}}][]" class="check-free" value="{{$item['detail_anggota'][$i]['anggota']['id']}}" checked>
                                        {{$item['detail_anggota'][$i]['anggota']['nama']}}
                                    </label>
                                    <span class="isKetua" data-id="{{$item['detail_anggota'][$i]['anggota']['id']}}">Jadikan Ketua</span>
                                </div>
                            @endfor
                        </div>
                        <input type="hidden" name="ketua[]" class="hidden_ketua" value="{{$ketua}}">
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
