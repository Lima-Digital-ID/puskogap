@extends('layouts.template')

@section('page-header')
    @include('components.page-header', [
    'pageTitle' => $pageTitle,
    'pageSubtitle' => '',
    'pageIcon' => $pageIcon,
    'parentMenu' => $parentMenu,
    'current' => $current
    ])
@endsection

@section('content')

    @include('components.notification')

    @include('components.button-add', ['btnText' => $btnText, 'btnLink' => $btnLink])
    
    <div class="card">
        <div class="card-header">
            <h5>List {{ $pageTitle }}</h5>
            <div class="col-md-4 pull-right">
                @include('components.search')
            </div>
            
        </div>
        <div class="card-block table-border-style">
            @include('jabatan._table')
        </div>
    </div>

@endsection
