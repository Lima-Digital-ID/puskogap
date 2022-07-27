@extends('layouts.template')

@section('content')

    @include('components.notification')
    <form action="" method="get">
        <div class="row">
            <div class="col-md-6">
            <label>Tanggal</label>
            <div class="input-group">
                <div class="input-group-prepend">
                    <button class=" input-group-text">
                        <span class="fa fa-calendar"></span>
                    </button>
                </div>
                <input type="text" name='tanggal' class="form-control datepicker" value="{{isset($_GET['tanggal']) ? $_GET['tanggal'] : ''}}">
            </div>
            </div>
            </div>
            <div class="row">

                <div class="col mt-3">
                    <button class="btn btn-primary"><span class="fa fa-filter"></span> Filter</button>
                </div>
            </div>
    </form>
    <br>

@endsection
