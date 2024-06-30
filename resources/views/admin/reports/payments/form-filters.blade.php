<div class="row">
    <form method="GET" action={{ route('admin.reports.payments') }} class="col-12">
        @csrf

        <div class="card" style="border: 1px solid #c1b8f7;">
        <div class="card-header" style="background-color: #7c69ef78;">
            <h5><i class="las la-filter"></i> Filtros</h3>  
        </div>
        <div class="card-body">
            
            <div class="row">

                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <label for="datepicker" class="form-label">Rango de Fechas</label>
                    <div class="input-group">
                        <div class="input-group-prepend"><span class="input-group-text h-100"><i class="las la-calendar"></i></span></div>
                        <input type="text" class="form-control" id="datepicker" name="filters[range_date]" placeholder="Seleccione Fecha">
                    </div>
                </div>
            
            
            </div>  

            <div class="row mt-2">
                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <label for="client_id" class="form-label mb-0">Clientes</label>
                    <div class="input-group d-flex flex-row flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text h-100"><i class="las la-angle-double-down"></i></span>
                        </div>
                        <select class="form-control select2" id="client_id" name="filters[client_id]">
                            <option value="">Seleccione</option>
                            @foreach($clients as $key => $value)
                                <option value="{{ $key }}" {{ request('filters.client_id') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="col-12 col-md-6 mb-3 mb-md-0">
                    <label for="contract_id" class="form-label mb-0">Contratos</label>
                    <div class="input-group d-flex flex-row flex-nowrap">
                        <div class="input-group-prepend">
                            <span class="input-group-text h-100"><i class="las la-angle-double-down"></i></span>
                        </div>
                        <select class="form-control select2" id="contract_id" name="filters[contract_id]">
                            <option value="">Seleccione</option>
                            @foreach($contracts as $key => $value)
                                <option value="{{ $key }}" {{ request('filters.contract_id') == $key ? 'selected' : '' }}>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

            </div>

            <div class="row">
                <div class="col-12 text-end mt-2">
                <a class="btn btn-secondary mr-2" href="{{ route('admin.reports.payments')}}"><i class="fa fa-search"></i> Reiniciar</a>
                <button class="btn btn-primary" type="submit"><i class="fa fa-search"></i> Filtrar</button>
                </div>
            </div>
        </div>

        </div>

    </form>
</div>