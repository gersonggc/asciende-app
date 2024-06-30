@extends('errors.layout')

@php
  $error_number = 400;
@endphp

@section('title')
  Bad request.
@endsection

@section('description')
  @php
    $default_error_message = "Please <a href="route('')>go back</a> or return to <a href="{{ url('dashboard') }}">our homepage</a>.";
  @endphp
  {!! isset($exception)? ($exception->getMessage()?e($exception->getMessage()):$default_error_message): $default_error_message !!}
@endsection
