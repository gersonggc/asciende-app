@php
$contract_id = request()->input('contract_id');
$installments = \App\Models\Installment::where('contract_id', $contract_id)
    ->whereIn('status', ['PENDING', 'PARTIAL_PAID'])
    ->orderBy('due_date', 'asc')
    ->get();

$firstInstallmentId = null;

if ($installments->count() > 0) {
	$firstInstallmentId = $installments->first()->id;
}

@endphp

@if($firstInstallmentId && $entry->getKey() === $firstInstallmentId)
	<a class="btn btn-sm btn-link" href={{url('/admin/payment/create?installment_id='.$entry->getKey())}}>
			<span class="badge rounded-pill text-bg-success"><i class="la la-check-circle me-2"></i> Pagar Cuota</span>
	</a>
@endif




