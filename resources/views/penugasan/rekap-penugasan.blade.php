@extends('layouts.template')

@section('content')

    @include('components.notification')
    <form action="" method="get">
        <div class="row">
            <div class="col-md-6">
            <label>Dari Tanggal</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class=" input-group-text">
                        <span class="fa fa-calendar"></span>
                    </button>
                </div>
                <input type="text" name='dari' class="form-control datepicker" value="{{isset($_GET['dari']) ? $_GET['dari'] : date('Y-m-d')}}">
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
                    <input type="text" name='sampai' class="form-control datepicker" value="{{isset($_GET['sampai']) ? $_GET['sampai'] : date('Y-m-d')}}">
                </div>
            </div>
            <div class="col mt-3">
                <button class="btn btn-primary"><span class="fa fa-filter"></span> Filter</button>
            </div>
        </div>
    </form>
    @if(isset($data))
    <hr>
        @include('penugasan._table',['viewOption' => 'detail'])
    @endif
    
    @endsection
    