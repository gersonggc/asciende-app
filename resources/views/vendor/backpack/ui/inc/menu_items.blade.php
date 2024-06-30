<li class="nav-item"><a class="nav-link" href="{{ backpack_url('/dashboard') }}"><i class="la la-home nav-icon"></i> Asciende App</a></li>

<x-backpack::menu-item title="Clientes" icon="la la-users" :link="backpack_url('client')" />
<x-backpack::menu-item title="Contracts" icon="la la-file-invoice-dollar" :link="backpack_url('contract')" />


<li class="nav-item nav-dropdown">
    <a class="nav-link nav-dropdown-toggle" href="#"><i class="nav-icon la la-coins"></i>Reportes</a>
    <ul class="nav-dropdown-items">
        <!-- <li class="nav-item"><a class="nav-link" href="{{ route('admin.reports.proyection') }}"><i class="nav-icon la la-hand-holding-usd"></i> <span>Proyeccion</span></a></li> -->
        <!-- <li class="nav-item"><a class="nav-link" href="{{ route('admin.reports.installments') }}"><i class="nav-icon la la-hand-holding-usd"></i> <span>Reporte Cuotas</span></a></li> -->
        <x-backpack::menu-item title="Proyeccion" icon="la la-hand-holding-usd" :link="route('admin.reports.proyection')" />
        <x-backpack::menu-item title="Reporte Cuotas" icon="la la-hand-holding-usd" :link="route('admin.reports.installments')" />
        <x-backpack::menu-item title="Reporte Pagos" icon="la la-hand-holding-usd" :link="route('admin.reports.payments')" />
    </ul>
</li>

