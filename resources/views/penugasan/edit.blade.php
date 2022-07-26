@extends('layouts.template')

@section('content')
    @include('components.notification')

    @include('penugasan._form-edit')
@endsection
@push('custom-script')
@include('penugasan.penugasan-js')
@endpush
