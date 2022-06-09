@extends('layouts.template')

@section('page-header')
    @include('components.page-header', [
        'pageTitle' => 'Dashboard',
        'pageSubtitle' => '',
        'pageIcon' => 'feather icon-home',
        'parentMenu' => '',
        'current' => 'Dashboard'
    ])
@endsection

@include('components.notification')
@section('content')
    <div class="row mt-4">
        <div class="col">
            <div class="alert alert-primary font-weight-bold">Selamat Datang Di Aplikasi PUSKOGAP</div>
        </div>
    </div>
    @if (auth()->user()->level == 'Administrator' || auth()->user()->level == 'Admin' || auth()->user()->level == 'Kasat')
    <div class="row">
    <div class="col-md-3 mb-4">
        <div class="card bg-rgb-info border border-info">
            <div class="card-body py-4">  
                <span class="fa fa-calendar-alt sticky-fa-card"></span>  
                <div class="row align-items-center">
                    <div class="col-md-8 pr-0 font-weight-bold">
                        Rencana Penugasan
                    </div>
                    <div class="col-md-4 pr-0 text-center">
                        <h1>{{ \App\Models\Penugasan::where('status','Rencana')->count() }}</h1>
                    </div>
                </div>
                <hr>
                <a href="{{url('penugasan?status=Rencana')}}" class="btn btn-info btn-sm b-radius-3 px-3">Lihat Detail</a>
            </div>
        </div>
    </div>
    <div class="col-md-3 mb-4">
        <div class="card bg-rgb-primary border border-primary">
            <div class="card-body py-4">    
                    <i class="fas fa-car sticky-fa-card"></i>  
                    <div class="row">
                        <div class="col-md-8 pr-0 font-weight-bold">
                            Penugasan Berlangsung
                        </div>
                        <div class="col-md-4 pl-0 text-center font-weight-bold">
                            <h1>{{ \App\Models\Penugasan::where('status','Pelaksanaan')->count() }}</h1>
                        </div>
                    </div>
                    <hr>
                    <a href="{{url('penugasan?status=Pelaksanaan')}}" class="btn btn-primary btn-sm b-radius-3 px-3">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-rgb-success border border-success">
                <div class="card-body py-4">    
                    <i class="fas fa-calendar-check sticky-fa-card"></i>  
                    <div class="row font-weight-bold">
                        <div class="col-md-8 pr-0">
                            Penugasan Telah Selesai
                        </div>
                        <div class="col-md-4 pl-0 text-center">
                            <h1>{{ \App\Models\Penugasan::where('status','Selesai')->count() }}</h1>
                        </div>
                    </div>
                    <hr>
                    <a href="{{url('penugasan?status=Selesai')}}" class="btn btn-success btn-sm b-radius-3 px-3">Lihat Detail</a>
                </div>
            </div>
        </div>
        <div class="col-md-3 mb-4">
            <div class="card bg-rgb-danger border border-danger">
                <div class="card-body py-4">    
                    <i class="fa fa-ban sticky-fa-card"></i>  
                    <div class="row font-weight-bold">
                        <div class="col-md-8 pr-0">
                            Penugasan Dibatalkan
                        </div>
                        <div class="col-md-4 pl-0 text-center">
                            <h1>{{ \App\Models\Penugasan::where('status','Batal')->count() }}</h1>
                        </div>
                    </div>
                    <hr>
                    <a href="{{url('penugasan?status=Batal')}}" class="btn btn-danger btn-sm b-radius-3 px-3">Lihat Detail</a>
                </div>
            </div>
        </div>
    </div>
    <br>
    @endif
    <div class="row">
        <div class="col-md-6">
            <h5 class="font-weight-bold color-darkBlue">Kegiatan Penugasan Hari Ini</h5>
        </div>
        <div class="col-md-6 text-right">
            <a href="{{url('penugasan')}}">Lihat Semua Penugasan</a>
        </div>
    </div>
    <hr class="mt-2">
    @php
    $getPenugasan = \App\Models\Penugasan::select('p.id','nama_kegiatan','lokasi','p.status','jp.jenis_kegiatan',\DB::raw("min(wp.tanggal) as tanggal_mulai,max(wp.tanggal) as tanggal_selesai,min(wp.waktu_mulai) as waktu_mulai,max(wp.waktu_selesai) as waktu_selesai"))->from('penugasan as p')->join('jenis_kegiatan as jp','p.id_jenis_kegiatan','jp.id')->join('waktu_penugasan as wp','p.id','wp.id_penugasan');
    if(auth()->user()->level=='Anggota'){
        $getPenugasan->leftJoin('detail_anggota as da','wp.id','da.id_waktu_penugasan')
        ->where('da.id_anggota', auth()->user()->id_anggota);
    }
    $getPenugasan->where('wp.tanggal',date('Y-m-d'))
    ->groupBy('p.id','nama_kegiatan','lokasi','p.status','jp.jenis_kegiatan')
    ->orderBy('p.id');

    $data = $getPenugasan->paginate(10);
    @endphp
    @include('penugasan._table')

@endsection