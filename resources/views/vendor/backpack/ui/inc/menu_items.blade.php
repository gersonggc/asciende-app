{{-- This file is used for menu items by any Backpack v6 theme --}}
<li class="nav-item"><a class="nav-link" href="{{ backpack_url('dashboard') }}"><i class="la la-home nav-icon"></i> {{ trans('backpack::base.dashboard') }}</a></li>

<x-backpack::menu-item title="Clientes" icon="la la-users" :link="backpack_url('client')" />
<x-backpack::menu-item title="Contracts" icon="la la-file-invoice-dollar" :link="backpack_url('contract')" />
<!-- <x-backpack::menu-item title="Installments" icon="la la-question" :link="backpack_url('installment')" />
<x-backpack::menu-item title="Payments" icon="la la-question" :link="backpack_url('payment')" /> -->