@extends('layouts.template')

@section('content')

    @include('components.notification')
    <div class="row">
        <div class="col-md-4">
            <label>Tanggal</label>
            <input type="text" name="tanggal" class="form-control datepicker" id="">
        </div>
        <div class="col-md-4">
            <label>Waktu Mulai</label>
            <input type="time" name="waktu_mulai" value='00:00' class="form-control datepicker" id="">
        </div>
        <div class="col-md-4">
            <label>Waktu Selesai</label>
            <input type="time" name="waktu_selesai" value="23:59" class="form-control datepicker" id="">
        </div>
        <div class="col mt-3">
            <button class="btn btn-primary"><span class="fa fa-filter"></span> Lihat Anggota</button>
        </div>
    </div>
    <hr>
    <div class="row" style="display: none">
        <div class="col-md-6">
            <div class="card card-free">
                <div class="card-header btn-rgb-primary">
                    <h6 class="mb-0">Anggota Free</h6>
                </div>
                <div class="card-body">
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card card-bertugas" style="height:100%">
                <div class="card-header btn-rgb-success">
                    <h6 class="mb-0">Anggota Bertugas</h6>
                </div>
                <div class="card-body">
                </div>
            </div>
        </div>
    </div>    
@endsection
