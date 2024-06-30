@if($entry->status === 'ACTIVE')
  <a class="dropdown-item toggleModal" href={{url($crud->route.'/'.$entry->getKey().'/reject')}} 
    data-toggle="tooltip" 
    title="Anular Codigo Temporal"
    >
    <i class="la la-times text-danger"></i> 
    <span span class="badge badge-danger">Anular</span>
  </a>
@endif