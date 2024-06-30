@extends(backpack_view('blank'))
@section('content')
<div class="row flex-column">
  <div class="row mb-0">
    <div class="col-sm-6">
      <div class="d-print-none with-border">

      </div>
    </div>
  </div>
  <div class="row">
    <div class="col-12">
      @include('errors.flash-message')
      <div class="card">
        <div class="card-header"><h3><i class="las la-align-justify"></i> Reporte de proyeccion de Ganancias</h3></div>
        <div class="card-body">
          <div class="form-group row">
            <div class="col-12">
              <form method="GET" action={{ route('admin.reports.proyection') }}>
              <div class="col-sm-12 col-md-4 col-xl-4 " bis_skin_checked="1">
                <div class="input-group" bis_skin_checked="1">
                  <div class="input-group-prepend" bis_skin_checked="1"><span class="input-group-text h-100"><i class="las la-calendar"></i></span></div>
                  <input class="form-control" id="datepicker" type="text" name="range_date" placeholder="Seleccione Fecha">
                  <span class="input-group-append">
                    <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i>Filtrar</button></span>
                </div>
              </div>
              </form>
            </div>
          </div>

          <div class="row mt-4">
            <div class="col-sm-12 col-md-6 col-xl-6">

                <div class="card-stats card" bis_skin_checked="1">
                  <div class="card-body" bis_skin_checked="1">
                    <div class="row" bis_skin_checked="1">
                      
                      <div class="col" bis_skin_checked="1">
                        <h5 class="text-uppercase text-muted mb-0 card-title">Ganancias Proyectadas Para el periodo</h5>
                        <span class="h2 font-weight-bold mb-0 mt-1">{{ $projectedProfit }} $</span>
                      </div>
                      
                      <div class="col-auto col" bis_skin_checked="1">
                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow" bis_skin_checked="1">
                          <i class="las la-coins"></i>
                        </div>
                      </div>
                    </div>

                    <p class="mt-3 mb-0 text-sm">
                      <!-- <span class="text-success mr-2">
                        <i class="fa fa-arrow-up"></i> 3.48%</span> 
                        <span class="text-nowrap">Since last month</span>
                    </p> -->
                  </div>
                </div>

            </div>
            
            <div class="col-sm-12 col-md-6 col-xl-6  mt-2 mt-md-0">

                <div class="card-stats card" bis_skin_checked="1">
                  <div class="card-body" bis_skin_checked="1">
                    <div class="row" bis_skin_checked="1">
                      
                      <div class="col" bis_skin_checked="1">
                        <h5 class="text-uppercase text-muted mb-0 card-title">Ganancias Efectivas Para el periodo</h5>
                        <span class="h2 font-weight-bold mb-0 mt-1">{{ $profitPayment }} $</span>
                      </div>
                      
                      <div class="col-auto col" bis_skin_checked="1">
                        <div class="icon icon-shape bg-gradient-green text-white rounded-circle shadow" bis_skin_checked="1">
                          <i class="las la-coins"></i>
                        </div>
                      </div>
                    </div>

                    <p class="mt-3 mb-0 text-sm">
                      <span class="text-success mr-2">
                        <!-- <i class="fa fa-arrow-up"></i> 3.48%</span> 
                        <span class="text-nowrap">Since last month</span> -->
                    </p>
                  </div>
                </div>

            </div>
            
          </div>  
        
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('after_styles')
    <link rel="stylesheet" href="{{ asset('css/reports.css') }}">
@endpush


@push('after_scripts')
    <script src="{{ asset('/js/easepicker.js') }}"></script>
    <script>
        const picker = new easepick.create({
            element: "#datepicker",
            css: [
                `{{ asset('/css/easepicker.css') }}`
            ],
            zIndex: 10,
            grid: 2,
            calendars: 2,
            format: 'DD/MM/YYYY',
            inline: false,
            header: "Calendario",
            lang: 'es-MX',
            plugins: [
                "RangePlugin",
                "AmpPlugin",
                "LockPlugin",
                "PresetPlugin"
            ],
            PresetPlugin: {
                customLabels: ['Hoy', 'Ayer', 'Últimos 7 días', 'Últimos 30 días', 'Este mes', 'Mes pasado']
            },
        });
        picker.setStartDate(`{{ $from }}`);
        picker.setEndDate(`{{ $to }}`);
    </script>
@endpush
