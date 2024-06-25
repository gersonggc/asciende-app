<!-- resources/views/vendor/backpack/crud/list_payments.blade.php -->
@extends(backpack_view('blank'))

@section('content')
<section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none" bp-section="page-header">
    <h1 class="text-capitalize mb-0" bp-section="page-heading">Pagos</h1>
    <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">Listado de Pagos</p>
    <p class="mb-0 ms-2 ml-2" bp-section="page-subheading-back-button">
        <small>
            <a href="{{ url('/admin/contract') }}" class="d-print-none font-sm">
                <span><i class="la la-angle-double-left"></i> Volver al listado de <span>Cuotas</span></span>
            </a>
        </small>
    </p>
</section>

<div class="container">
    @include('crud::inc.grouped_errors')

    {{-- Aquí va la tabla de listado de pagos --}}
    @if ($crud->hasAccess('list'))
        <div class="row">
            <div class="{{ $crud->getListContentClass() }}">
                @include($crud->getListView())
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning">
                    {{ trans('backpack::crud.unauthorized_access') }}
                </div>
            </div>
        </div>
    @endif
</div>
@endsection