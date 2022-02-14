<form action="{{ route('penugasan.store') }}" method="POST"  enctype="multipart/form-data">
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
        <div class="col-md-6">
            <label>Jenis Kegiatan</label>
            <select name="id_jenis_kegiatan" class="select2 form-control" style="width: 100%;" required>
                <option value="0">Pilih Jenis Kegiatan</option>
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
            <label>Tanggal Kegiatan</label>
            <div class="input-group">
                <input type="date" id="pilih-tanggal" class="form-control" placeholder="Pilih Tanggal Kegiatan">
                <div class="input-group-append">
                    <button class="btn btn-success"><span class="fa fa-calendar"></span> Jadwalkan</button>
                </div>
            </div>

        </div>
    </div>
    {{-- <div id="kegiatan-khusus">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Tanggal Mulai</label>
            <div class="col-sm-10">
                <input type="date" name="tanggal_mulai" class="form-control ambilAnggota @error('tanggal_mulai') is-invalid @enderror" placeholder="Nama tanggal_mulai" value="{{old('tanggal_mulai')}}">
                @error('tanggal_mulai')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
        
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Tanggal Selesai</label>
            <div class="col-sm-10">
                <input type="date" name="tanggal_selesai" class="form-control ambilAnggota @error('tanggal_selesai') is-invalid @enderror" placeholder="Nama tanggal_selesai" value="{{old('tanggal_selesai')}}">
                @error('tanggal_selesai')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
            </div>
        </div>
    </div> --}}
    {{-- <div id="kegiatan-mingguan" style="display:none">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Pilih Hari</label>
            <div class="col-sm-10">
                <select name="is_mingguan[]" class="js-example-basic-single select-hari ambilAnggota @error('is_mingguan') is-invalid @enderror" multiple="multiple" style="width: 100%;">
                    <?php 
                        $day = ["Minggu",'Senin','Selasa','Rabu','Kamis',"Jum'at",'Sabtu'];
                    ?>

                    @foreach ($day as $key => $value) 
                        @php $key++ @endphp
                        <option value="{{$key}}">{{$value}}</option>
                    @endforeach
                </select>
                @error('is_mingguan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div>
    <div id="kegiatan-bulanan" style="display:none">
        <div class="form-group row">
            <label class="col-sm-2 col-form-label">Pilih Tanggal</label>
            <div class="col-sm-10">
                <div class="isBulanan">
                    <input type="text" name="is_tanggal" class="form-control select-tanggal ambilAnggota" readonly>
                    <div class="date">
                        <p>Pilih Tanggal</p>
                        <?php 
                                for($i=1;$i<=31;$i++){
                                    if($i%10==1){
                                        echo '<div class="row-date">';
                                    }
                                        echo "<span>$i</span>";
                                    if($i%10==0 || $i==31){
                                        echo '</div>';
                                    }
                                }
                        ?>
                    </div>
                </div>
                @error('is_bulanan')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
        </div>
    </div> --}}
    {{-- <div class="form-group row">
        <label class="col-sm-2 col-form-label">Waktu Mulai</label>
        <div class="col-sm-10">
        <input type="time" name="waktu_mulai" class="form-control ambilAnggota @error('waktu_mulai') is-invalid @enderror" placeholder="Nama waktu_mulai" value="{{old('waktu_mulai')}}">
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
        <input type="time" name="waktu_selesai" class="form-control ambilAnggota @error('waktu_selesai') is-invalid @enderror" placeholder="Nama waktu_selesai" value="{{old('waktu_selesai')}}">
        @error('waktu_selesai')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
        </div>
    </div> --}}
    {{-- <div class="form-group row" id="ketua">
        <label class="col-sm-2 col-form-label">Ketua</label>
        <div class="col-sm-10">
            <select name="ketua" class="js-example-basic-single" style="width: 100%;">
                <option value="">Pilih Ketua</option>
                <option value="1">Pilih Aku</option>
            </select>
        </div>
    </div> --}}

    
    <button type="submit" class="btn btn-primary mr-2"><i class="fa fa-save"></i> Simpan</button>
    <button type="reset" class="btn btn-default"><i class="fa fa-times"></i> Reset</button>
</form>
