@extends('layouts.template')

@section('content')
    @include('components.notification')

    @include('penugasan._form-create')
@endsection
@push('custom-script')
@include('penugasan.penugasan-js')
@endpush
