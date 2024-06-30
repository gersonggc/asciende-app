@extends(backpack_view('blank'))

@section('header')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <section class="header-operation container-fluid animated fadeIn d-flex mb-2 align-items-baseline d-print-none" bp-section="page-header">
                    <h1 class="text-capitalize mb-0" bp-section="page-heading">Pagos</h1>
                    <p class="ms-2 ml-2 mb-0" bp-section="page-subheading">Listado de Pagos.</p>
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
                        <li class="breadcrumb-item"><a href="{{ url('/admin') }}">{{ trans('backpack::crud.admin') }}</a></li>
                        <li class="breadcrumb-item active">{{ $crud->entity_name_plural }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
@endsection

@section('content')
<div class="{{ backpack_theme_config('classes.tableWrapper') }}">
    <table
        id="crudTable"
        class="{{ backpack_theme_config('classes.table') ?? 'table table-striped table-hover nowrap rounded card-table table-vcenter card d-table shadow-xs border-xs' }}"
        data-responsive-table="{{ (int) $crud->getOperationSetting('responsiveTable') }}"
        data-has-details-row="{{ (int) $crud->getOperationSetting('detailsRow') }}"
        data-has-bulk-actions="{{ (int) $crud->getOperationSetting('bulkActions') }}"
        data-has-line-buttons-as-dropdown="{{ (int) $crud->getOperationSetting('lineButtonsAsDropdown') }}"
        cellspacing="0">
        <thead>
            <tr>
                {{-- Table columns --}}
                @foreach ($crud->columns() as $column)
                    <th
                        data-orderable="{{ var_export($column['orderable'], true) }}"
                        data-priority="{{ $column['priority'] }}"
                        data-column-name="{{ $column['name'] }}"
                        data-visible-in-table="{{ var_export($column['visibleInTable'] ?? false) }}"
                        data-visible="{{ var_export($column['visibleInTable'] ?? true) }}"
                        data-can-be-visible-in-table="true"
                        data-visible-in-modal="{{ var_export($column['visibleInModal'] ?? true) }}"
                        @if(isset($column['visibleInExport']))
                            data-visible-in-export="{{ var_export($column['visibleInExport'] ?? true) }}"
                            data-force-export="{{ var_export($column['visibleInExport'] !== false) }}"
                        @else
                            data-visible-in-export="true"
                            data-force-export="false"
                        @endif
                    >
                        {{-- Bulk checkbox --}}
                        @if($loop->first && $crud->getOperationSetting('bulkActions'))
                            {!! View::make('crud::columns.inc.bulk_actions_checkbox')->render() !!}
                        @endif
                        {!! $column['label'] !!}
                    </th>
                @endforeach

                @if ($crud->buttons()->where('stack', 'line')->count())
                    <th data-orderable="false"
                        data-priority="{{ $crud->getActionsColumnPriority() }}"
                        data-visible-in-export="false"
                        data-action-column="true">
                        {{ trans('backpack::crud.actions') }}
                    </th>
                @endif
            </tr>
        </thead>
        <tbody>
          @foreach ($crud->getEntries() as $entry)
            <tr>
              @foreach ($crud->columns() as $key => $column)
                <td>
                  {{-- Bulk checkbox --}}
                  @if($loop->first && $crud->getOperationSetting('bulkActions'))
                    {!! View::make('crud::columns.inc.bulk_actions_checkbox')->render() !!}
                  @endif

                  {!! $entry->{$column['name']} !!}
                  
                </td>
              @endforeach

              @if ($crud->buttons()->where('stack', 'line')->count())
                  <td>
                      @include('crud::inc.button_stack', ['stack' => 'line'])
                  </td>
              @endif
            </tr>
          @endforeach
        </tbody>
        <tfoot>
            <tr>
                @foreach ($crud->columns() as $column)
                    <th>
                        {{-- Bulk checkbox --}}
                        @if($loop->first && $crud->getOperationSetting('bulkActions'))
                            {!! View::make('crud::columns.inc.bulk_actions_checkbox')->render() !!}
                        @endif
                        {!! $column['label'] !!}
                    </th>
                @endforeach

                @if ($crud->buttons()->where('stack', 'line')->count())
                    <th>{{ trans('backpack::crud.actions') }}</th>
                @endif
            </tr>
        </tfoot>
    </table>
</div>
@endsection
