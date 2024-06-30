<div class="row">  
    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover table-bordered">
            <thead>
            <tr>
                <th>Cliente</th>
                <th>Contracto | Cuota</th>
                <th>Fecha Vencimiento</th>
                <th>Monto</th>
                <th>Estatus</th>
                <th>Accion</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($installments as $installment )
                <tr>
                    <td>{{ $installment->client }}</td>
                    <td>{{ $installment->installment_number }}</td>
                    <td>{{ $installment->due_date }}</td>
                    <td>{{ $installment->total_payment_list }}</td>
                    <td><span class="{{ $statusClass[$installment->status] }}">{{ $statuses[$installment->status] }}</span></td>
                    <td>{!! $installment->getPaymenInstallmentButton() !!}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>