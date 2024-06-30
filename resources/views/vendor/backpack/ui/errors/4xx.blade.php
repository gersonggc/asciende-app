@extends(backpack_view('errors.layout'))

@php
  $error_number ??= 400;
@endphp

@section('title')
  {{ trans('backpack::base.error_page.'.$error_number) }}
@endsection

@section('description')
  {!! $exception?->getMessage() ? e($exception->getMessage()) : trans('backpack::base.error_page.message_4xx', [
    'href_back' => 'href="'.config('backpack.ui.home_link').'"',
    'href_homepage' => 'href="'.config('backpack.ui.home_link').'"',
  ]) !!}
@endsection
