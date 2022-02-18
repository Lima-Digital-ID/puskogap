@extends('layouts.template')

@section('content')

    @include('components.notification')

    
    @if (auth()->user()->level == 'Administrator' || auth()->user()->level == 'Admin' || auth()->user()->level == 'Kasat')
    <div class="row justify-content-between">
        <div class="col-md-6">
            @include('components.button-add', ['btnText' => $btnText, 'btnLink' => $btnLink])
        </div>     
        <div class="col-md-4">
            @include('components.search')
        </div>
    </div>
    @else
    <div class="row justify-content-end">
        <div class="col-md-4">
            @include('components.search')
        </div>
    </div>
    <br>
    @endif   
    @include('penugasan._table')

@endsection
