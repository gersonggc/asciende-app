
@if($entry->status === 'APPROVED')
  <a class="dropdown-item toggleModalWithField" href={{url($crud->route.'/revert/'.$entry->getKey())}}
    data-toggle="tooltip"
    title="Revertir"
    >
    <i class="la la-times text-danger"></i>
    <span span class="badge badge-danger">Revertir</span>
  </a>
@endif
