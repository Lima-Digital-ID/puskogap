@extends('layouts.template')

@section('content')

    @include('components.notification')
    <div class="row">
        <div class="col-md-6">
        <label>Dari Tanggal</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <button class=" input-group-text">
                    <span class="fa fa-calendar"></span>
                </button>
            </div>
            <input type="text" name='dari' class="form-control datepicker" id="dari" value="{{isset($_GET['dari']) ? $_GET['dari'] : ''}}">
        </div>
        </div>
        <div class="col-md-6">
            <label>Sampai Tanggal</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class=" input-group-text">
                        <span class="fa fa-calendar"></span>
                    </button>
                </div>
                <input type="text" name='sampai' class="form-control datepicker" id="sampai" value="{{isset($_GET['sampai']) ? $_GET['sampai'] : ''}}">
            </div>
        </div>
        <div class="col mt-3">
            <button class="btn btn-primary" onclick="getRekap()"><span class="fa fa-filter"></span> Filter</button>
        </div>
    </div>
    <br>
    <div class="table-responsive">
        <table class="table table-hover table-custom">
            <thead>
                <tr class="table-primary">
                    <th class="text-center">#</th>
                    <th>Nama</th>
                    <th>NIP</th>
                    <th>Jumlah Bertugas</th>
                </tr>
            </thead>
            <tbody id="myBody">
                {{-- @php
                    $page = Request::get('page');
                    $no = !$page || $page == 1 ? 1 : ($page - 1) * 10 + 1;
                @endphp
                @foreach ($data as $item)
                    <tr class="border-bottom-primary">
                        <td class="text-center text-muted">{{ $no }}</td>
                        <td>{{ $item->nama }}</td>
                        <td>{{ $item->nip }}</td>
                        <td>{{ $item->total }}</td>
                    @php
                        $no++;
                    @endphp
                @endforeach --}}
            </tbody>
        </table>
        <div class="pull-right">
            {{-- {{ $user->appends(Request::all())->links('vendor.pagination.custom') }} --}}
        </div>
    </div>
    
    

@endsection
@push('custom-script')
    <script>
        function getRekap(){
            var dari = $('#dari').val();
            var sampai = $('#sampai').val();
            var no = 1
            console.log("{{ url('rekap/get-anggota-bertugas') }}?dari="+dari+"&sampai="+sampai);
            $.ajax({
                type: "GET",
                url:"{{ url('rekap/get-anggota-bertugas') }}?dari="+dari+"&sampai="+sampai,
                dataType : "json",
                success : function(response){
                    // if success response
                    $('#myBody').empty()
                    arrData = response;
                    for(i = 0; i < arrData.length; i++){
                    $('#myBody').append(`
                                <tr class="border-bottom-primary">
                                    <th class="text-center">${no++}</th>
                                    <th>${arrData[i].nama}</th>
                                    <th>${arrData[i].nip}</th>
                                    <th>${arrData[i].total}</th>
                                </tr>
                        `)
                    }
                }
            })
        }
    </script>
@endpush