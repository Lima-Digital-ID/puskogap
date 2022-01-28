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
    {{--  <div class="row">
        <div class="col-md-12">
            <div class="card sale-card">
                <div class="card-header">
                    <h5>HLS</h5>
                </div>
                <div class="card-block">
                    <figure class="highcharts-figure">
                        <div id="container-hls"></div>
                        <p class="highcharts-description">
                        </p>
                    </figure>                    
                </div>
            </div>
        </div>
    </div>  --}}

    </div>
@endsection