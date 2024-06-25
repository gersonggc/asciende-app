@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Listado de Cuotas</h1>

        <table class="table">
            <thead>
                <tr>
                    <th>Número de Cuota</th>
                    <th>Fecha de Vencimiento</th>
                    <th>Monto</th>
                    <th>Estado</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($installmets as $installment)
                    <tr>
                        <td>{{ $installment->numero }}</td>
                        <td>{{ $installment->fecha_vencimiento }}</td>
                        <td>{{ $installment->monto }}</td>
                        <td>{{ $installment->estado }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection