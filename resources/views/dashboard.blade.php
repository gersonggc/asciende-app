@extends(backpack_view('blank'))

@section('content')
<div class="table-content row">
  <div class="col-12">
    @include('errors.flash-message')
    <div class="card">
      <div class="card-header">
        <h3><i class="las la-align-justify"></i> Pagos Pendientes de la Semana</h3>
      </div>
      <div class="card-body">
        @foreach($pendingPayments as $week_day => $days)
          <div class="table-responsive mt-4">
            <table class="table table-striped table-hover table-bordered">
              <thead>
                <tr>
                  <th colspan="3"><h5 class="badge rounded-pill text-bg-info"><i class="las la-align-justify"></i> {{ $week_day }}</h5></th>
                </tr>
                <tr>
                  <th>Cliente</th>
                  <th>Fecha de Vencimiento</th>
                  <th>Monto</th>
                </tr>
              </thead>
              <tbody>
                @foreach($days as $day)
                  <tr>
                    <td>{{ $day->client }}</td>
                    <td>{{ $day->due_date }}</td>
                    <td>{{ number_format($day->amount, 2, '.', ',') }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>
        @endforeach
      </div>
    </div>
  </div>
</div>
@endsection
