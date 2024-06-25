
@extends(backpack_view('blank'))

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none" bp-section="page-header">
                    <h1 class="text-capitalize mb-0" bp-section="page-heading">Pagos</h1>
                    <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">Añadir Pago.</p>
                    <p class="mb-0 ms-2 ml-2" bp-section="page-subheading-back-button">
                        <small>
                            <a href="{{ url('/admin/installment?contract_id=' . $contractId) }}" class="d-print-none font-sm">
                                <span><i class="la la-angle-double-left"></i> Volver al listado de <span>Cuotas</span></span>
                            </a>
                        </small>
                    </p>
                </section>
                <div class="col-sm-12 d-flex justify-content-end">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><span>{{ trans('backpack::crud.admin') }}</span></li>
                        <li class="breadcrumb-item"><span>{{ $crud->entity_name_plural }}</span></li>
                        <li class="breadcrumb-item active">{{ trans('backpack::crud.add') }}</li>
                    </ol>
                </div>

            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('content')

<div class="row">
    <div class="{{ $crud->getCreateContentClass() }}">
        <div class="col">
            @include('crud::inc.grouped_errors')
            <form method="post"
                  action="{{ url($crud->route) }}"
                  @if ($crud->hasUploadFields('create')) enctype="multipart/form-data" @endif>
                {!! csrf_field() !!}
                @include('crud::form_content', ['fields' => $crud->getFields('create'), 'action' => 'create'])
                <div>
                    @include('crud::inc.form_save_buttons')
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
