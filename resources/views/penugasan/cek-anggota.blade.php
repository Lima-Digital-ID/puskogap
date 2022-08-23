@extends('layouts.template')

@section('content')

    @include('components.notification')
    <div class="row">
        <div class="col-md-3">
            <label>Tanggal</label>
            <input type="text" name="tanggal" class="form-control datepicker" id="tanggal" value="{{date('Y-m-d')}}">
        </div>
        <div class="col-md-3">
            <label>Waktu Mulai</label>
            <input type="time" name="waktu_mulai" value='00:00' class="form-control" id="waktu_mulai">
        </div>
        <div class="col-md-3">
            <label>Waktu Selesai</label>
            <input type="time" name="waktu_selesai" value="23:59" class="form-control" id="waktu_selesai">
        </div>
        <div class="col-md-3">
            <label>Terakhir Bertugas</label>
            <select id="terakhir_bertugas" class="form-control select2">
                <option value="">---Tidak Ada---</option>
                @for ($i = 1; $i <= 7; $i++)
                    <option value="{{$i}}">{{$i}} Hari yang lalu </option>
                @endfor
            </select>
        </div>
        <div class="col mt-3">
            <button class="btn btn-primary" id="btn-filter"><span class="fa fa-filter"></span> Lihat Anggota</button>
        </div>
    </div>
    <hr>
    <div class="row" id="row-anggota" style="display: none">
        <div class="col-md-6">
            <div class="card card-free">
                <div class="card-header btn-rgb-primary">
                    <h6 class="mb-0">Anggota Tidak Bertugas</h6>
                </div>
                <div class="card-body">
                    <div class="loop-anggota-free"></div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-bertugas" style="height:100%">
                <div class="card-header btn-rgb-success">
                    <h6 class="mb-0">Anggota Bertugas</h6>
                </div>
                <div class="card-body">
                    <div class="loop-anggota-bertugas"></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-script')
<script>
    $(document).ready(function(){
        $("#btn-filter").click(function(){
            var tanggal = $("#tanggal").val()
            var waktu_mulai = $("#waktu_mulai").val()
            var waktu_selesai = $("#waktu_selesai").val()
            var terakhir_bertugas = $("#terakhir_bertugas").val()
            var dataSend = {tanggal : tanggal, dari :waktu_mulai, sampai : waktu_selesai, terakhir_bertugas:terakhir_bertugas}

            $.ajax({
                type: "GET",
                data : dataSend,
                url:"{{ url('penugasan/get-anggota') }}",
                dataType : "json",
                beforeSend : function(){
                    $(".loop-anggota-free").prepend('<p>Loading....</p>')
                    $(".loop-anggota-bertugas").prepend('<p>Loading....</p>')
                },
                success : function(response){
                    $("#row-anggota").show()
                    appendAnggotaFree(response.free);
                    appendAnggotaNotFree(response.tugas);
                }
            })
        })
        function appendAnggotaFree(res){
            $(".loop-anggota-free").empty()
            $.each(res,function(key,val){
                key++
                $(".loop-anggota-free").append(`
                    <div class="mb-2">
                        <label>
                            ${key}. ${val.nama}
                        </label>
                    </div>
                `);
            })
        }
        function appendAnggotaNotFree(res){
            $(".loop-anggota-bertugas").empty()
            $.each(res,function(key,val){
                key++
                $(".loop-anggota-bertugas").append(`
                    <div class="mb-2">
                        <label class="mb-2">${key}. ${val.nama} (${val.nama_kegiatan})</label>
                    </div>
                `);
            })
        }

        $("#btn-filter").trigger('click')
    })
</script>
@endpush
