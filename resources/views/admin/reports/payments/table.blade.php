<div class="row">  
    <div class="table-responsive mt-4">
        <table class="table table-striped table-hover table-bordered">
            <thead>
            <tr>
                <th>Cliente</th>
                <th>Contracto | Cuota</th>
                <th>Fecha Pago</th>
                <th>Monto</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($payments as $payment )
                <tr>
                    <td>{{ $payment->installment->client }}</td>
                    <td>{{ $payment->installment_number }}</td>
                    <td>{{ \Carbon\Carbon::parse($payment->payment_date)->format('d/m/Y') }}</td>
                    <td>{{ $payment->amount }} $</td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
</div>