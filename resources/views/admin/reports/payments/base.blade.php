@extends(backpack_view('blank'))

@section('content')
<div class="table-content row">
  <div class="col-12">
    @include('errors.flash-message')
    <div class="card">
      <div class="card-header">
        
            <h3><i class="las la-align-justify"></i> Reporte de Pagos</h3>  
      </div>

      <div class="card-body">

        @include('admin.reports.payments.form-filters')

        @include('admin.reports.payments.table')
        
      </div>

      <div class="card-footer">
        <div class="d-flex justify-content-center">
          {{ $payments->appends(['filters' => request('filters')])->links('pagination::bootstrap-4') }}
        </div>
      </div>  

    </div>
  </div>
</div>  
@endsection

@include('admin.reports.payments.scripts')