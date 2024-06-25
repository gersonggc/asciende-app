<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\PaymentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class PaymentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class PaymentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    const LABELS = [
        'installment_id' => 'Numero de Cuota',
        'amount' => 'Monto Pagado',
        'payment_date' => 'Fecha del Pago',
        'notes' => 'Notas',
    ];
    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Payment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/payment');
        CRUD::setEntityNameStrings('Pago', 'Pagos');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $installment_id = request()->input('installment_id');

        if ( $installment_id ) {
            $this->crud->addClause('where', 'installment_id', '=', $installment_id)->orderBy('created_at', 'asc');
        }
        $this->crud->removeButton('create');
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');
        // $this->crud->addButtonFromView('top', 'volver', 'back_installment_list', 'right');
        // CRUD::setOperationSetting('lineButtonsAsDropdown', true);

        CRUD::column('installment.installment_number')->label(self::LABELS['installment_id']);
        
        CRUD::column('payment_date')->label(self::LABELS['payment_date']);
        CRUD::column('amount')->label(self::LABELS['amount']);

        // $this->crud->setListView('admin.payments.list'); // Usar la vista personalizad
        
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(PaymentRequest::class);
        $installment_id = $contract_id = $this->crud->getRequest()->installment_id;
        $installment = \App\Models\Installment::find($installment_id);

        $this->crud->addField([
            'name' => 'installment_id',
            'type' => 'hidden',
            'value' => $installment_id,
        ]);

        $this->crud->addField([
            'name' => 'installment_number',
            'label' => 'Numero de Cuota',
            'value' => $installment->installment_number,
            'attributes' => [
                'class' => 'form-control',
                'disabled' => true
            ]
        ]);

        $this->crud->addField([
            'name' => 'amount_pending',
            'label' => 'Monto pendiente de la Cuota',
            'type' => 'text',
            'value' => $installment->pending_amount.' $',
            'attributes' => [
                'class' => 'form-control',
                'disabled' => true
            ]
        ]);

        $this->crud->addField([
            'name' => 'amount',
            'label' => 'Monto a Pagadar',
            'type' => 'number',
            'attributes' => [
                'class' => 'form-control'
            ]
        ]);

        $this->crud->addField([
            'name' => 'payment_date',
            'label' => 'Fecha de Pago',
            'type' => 'date',
            'attributes' => [
                'class' => 'form-control'
            ]
        ]);

        $this->crud->addField([
            'name' =>'notes',
            'label' => 'Observaciones',
            'type' => 'summernote',
            'hint' => 'Observaciones',
            'options' => [
                'toolbar' => [
                    ['style', ['bold', 'italic', 'underline', 'clear']],
                    ['font', ['strikethrough', 'superscript', 'subscript']],
                    ['fontname', ['fontname']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['height', ['height']]
                ]
            ],
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Observaciones'
            ]
        ]);

        $installment_id = request()->get('installment_id');
        $installment = \App\Models\Installment::find($installment_id);
        $contractId = $installment->contract_id;
        view()->share('contractId', $contractId);

        $this->crud->setCreateView('admin.payments.create');

    }

    public function store()
    {
        // Ejecuta la operación de guardar del padre
        $response = $this->traitStore();

        // Obtén el `contract_id` de la solicitud
        $installment_id = request()->input('installment_id');
        $installment = \App\Models\Installment::find($installment_id);

        // Redirige al listado de cuotas con el `contract_id`
        return redirect()->to('/admin/installment?contract_id=' . $installment->contract_id);
    }

    /**
     * Define what happens when the Update operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-update
     * @return void
     */
    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();
    }
}
