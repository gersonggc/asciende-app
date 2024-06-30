<a class="dropdown-item" href={{url('admin/card/print-pdf/'.\Illuminate\Support\Facades\Crypt::encryptString($entry->id))}}
  data-toggle="tooltip"
  title="Imprimir tarjeta"
  target="_blank"
  >
  <i class="las la-file-pdf text-danger"></i>
  <span span class="badge badge-danger">Pdf</span>
</a>

<a href="#" class="dropdown-item clipboard_card"
  data-toggle="tooltip"
  data-clipboard="{{ $entry->hash }}"
  title="Copiar Codigo de Tarjeta"
  >
  <i class="fa fa-clipboard text-success" aria-hidden="true"></i>
  <span span class="badge badge-success">Codigo</span>
</a>

@if($entry->printed)
  <a class="dropdown-item" href={{url('admin/card/unprint/'.$entry->hash)}}
    data-toggle="tooltip"
    title="Marcar Impresa tarjeta"
    >
    <i class="las la-print text-warning"></i>
    <span span class="badge badge-warning">Marcar No impresa</span>
  </a>
  @else
  <a class="dropdown-item" href={{url('admin/card/print/'.$entry->hash)}}
    data-toggle="tooltip"
    title="Marcar Impresa tarjeta"
    >
    <i class="las la-print text-success"></i>
    <span span class="badge badge-success">Marcar Impresa</span>
  </a>
@endif

@can('Activar Desactivar Tarjetas')
    @if($entry->status == 'ACTIVE')
        <a class="dropdown-item toggleModal" href={{url('admin/card/toggle-status/'.$entry->hash)}}
            data-toggle="tooltip"
            title="Desactivar Tarjeta"
            >
            <i class="las la-exclamation-circle text-error"></i>
            <span span class="badge badge-error">Desactivar</span>
        </a>
    @else
        <a class="dropdown-item toggleModal" href={{url('admin/card/toggle-status/'.$entry->hash)}}
            data-toggle="tooltip"
            title="Activar Tarjeta"
            >
            <i class="las la-chevron-down text-success"></i>
            <span span class="badge badge-success">Activar Tarjeta</span>
        </a>
    @endif
@endcan
