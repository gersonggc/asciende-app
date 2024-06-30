@if($entry->status === 'PENDING' )
  <a class="dropdown-item toggleModal" href={{url($crud->route.'/approve/'.$entry->getKey())}}
    data-toggle="tooltip"
    title="Aprobar Solicitud"
    ><i class="la la-check-circle text-success"></i>
    <span class="badge badge-success">Aprobar</span>
  </a>
  <a class="dropdown-item toggleModal" href={{url($crud->route.'/reject/'.$entry->getKey())}}
    data-toggle="tooltip"
    title="Rechazar Solicitud"
    >
    <i class="la la-times text-danger"></i>
    <span span class="badge badge-danger">Rechazar</span>
  </a>
@endif
