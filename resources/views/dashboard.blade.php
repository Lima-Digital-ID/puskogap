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

@section('content')
    @include('components.notification')
    <div class="row">
        <div class="col-md-4">
            <div class="card sale-card">
                <div class="card-header">
                    <h5>Golongan</h5>
                </div>
                <div class="card-block">
                    <figure class="highcharts-figure">
                        <div id="container-hls"></div>
                        <p class="highcharts-description">
                            Jumlah Golongan : {{ \App\Models\Golongan::count() }}
                        </p>
                    </figure>                    
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card sale-card">
                <div class="card-header">
                    <h5>Jabatan</h5>
                </div>
                <div class="card-block">
                    <figure class="highcharts-figure">
                        <div id="container-hls"></div>
                        <p class="highcharts-description">
                            Jumlah Jabatan : {{ \App\Models\Jabatan::count() }}
                        </p>
                    </figure>                    
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card sale-card">
                <div class="card-header">
                    <h5>Unit Kerja</h5>
                </div>
                <div class="card-block">
                    <figure class="highcharts-figure">
                        <div id="container-hls"></div>
                        <p class="highcharts-description">
                            Jumlah Unit Kerja : {{ \App\Models\UnitKerja::count() }}
                        </p>
                    </figure>                    
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card sale-card">
                <div class="card-header">
                    <h5>Kompetensi Khusus</h5>
                </div>
                <div class="card-block">
                    <figure class="highcharts-figure">
                        <div id="container-hls"></div>
                        <p class="highcharts-description">
                            Jumlah Kompetensi Khusus : {{ \App\Models\KompetensiKhusus::count() }}
                        </p>
                    </figure>                    
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card sale-card">
                <div class="card-header">
                    <h5>Jenis Kegiatan</h5>
                </div>
                <div class="card-block">
                    <figure class="highcharts-figure">
                        <div id="container-hls"></div>
                        <p class="highcharts-description">
                            Jumlah Jenis Kegiatan : {{ \App\Models\JenisKegiatan::count() }}
                        </p>
                    </figure>                    
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card sale-card">
                <div class="card-header">
                    <h5>User</h5>
                </div>
                <div class="card-block">
                    <figure class="highcharts-figure">
                        <div id="container-hls"></div>
                        <p class="highcharts-description">
                            Jumlah User : {{ \App\Models\User::count() }}
                        </p>
                    </figure>                    
                </div>
            </div>
        </div>
    </div>

    @php
    $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';

    $getPenugasan = \App\Models\Penugasan::with('jenis_kegiatan')->orderBy('id');

    if ($keyword) {
        $getPenugasan->where('penugasan', 'LIKE', "%{$keyword}%");
    }

    $getPenugasan->limit(5);

    $data = $getPenugasan->paginate(10);
    @endphp

    <div class="row">
        <div class="col-md-12">
            <div class="card sale-card">
                <div class="card-header">
                    <h5>Penugasan</h5>
                </div>
                <div class="card-block">
                    <figure class="highcharts-figure">
                        <div id="container-hls"></div>
                        <div class="table-responsive">
                            <table class="table table-hover table-custom">
                                <thead>
                                    <tr class="table-primary">
                                        <th class="text-center">#</th>
                                        <th>Nama Kegiatan</th>
                                        <th>Jenis Kegiatan</th>
                                        <th>Waktu Mulai</th>
                                        <th>Waktu Selesai</th>
                                        <th>Lokasi</th>
                                        <th>Tamu VVIP</th>
                                        <th>Biaya</th>
                                        <th>Jumlah Roda 4</th>
                                        <th>Jumlah Roda 2</th>
                                        <th>POC</th>
                                        <th>Jumlah HT</th>
                                        <th>Penyelenggara</th>
                                        <th>Jumlah Peserta</th>
                                        <th>Penanggung Jawab</th>
                                        <th>Lampiran</th>
                                        <th>Status</th>
                                        <th>Keterangan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $page = Request::get('page');
                                        $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
                                    @endphp
                                    @foreach ($data as $item)
                                        <tr class="border-bottom-primary">
                                          <td class="text-center text-muted">{{ $no }}</td>
                                          <td>{{ $item->nama_kegiatan }}</td>
                                          <td>{{ $item->jenis_kegiatan->jenis_kegiatan }}</td>
                                          <td>{{ $item->waktu_mulai }}</td>
                                          <td>{{ $item->waktu_selesai }}</td>
                                          <td>{{ $item->lokasi }}</td>
                                          <td>{{ $item->tamu_vvip }}</td>
                                          <td>{{ "Rp. " . number_format($item->biaya,2,',','.') }}</td>
                                          <td>{{ $item->jumlah_roda_4 }}</td>
                                          <td>{{ $item->jumlah_roda_2 }}</td>
                                          <td>{{ $item->poc }}</td>
                                          <td>{{ $item->jumlah_ht }}</td>
                                          <td>{{ $item->penyelenggara }}</td>
                                          <td>{{ $item->jumlah_peserta }}</td>
                                          <td>{{ $item->penanggung_jawab }}</td>
                                          <td align="center"><a href="{{ "upload/lampiran/".$item->lampiran }}" target="_blank" class="btn btn-info btn-sm mr-2"><i class="fa fa-file"></i></a></td>
                                          <td>{{ $item->status }}</td>
                                          <td>{{ $item->keterangan }}</td>
                                        </tr>
                                        @php
                                            $no++;
                                        @endphp
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="pull-right">
                              {{$data->appends(Request::all())->links('vendor.pagination.custom')}}
                            </div>
                          </div>
                    </figure>                    
                </div>
            </div>
        </div>
    </div>

    </div>
@endsection