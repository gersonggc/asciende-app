<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\InstallmentRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use App\Models\Installment;
use Illuminate\Support\Facades\Log;
use Exception;

/**
 * Class InstallmentCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class InstallmentCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    // use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation { update as traitUpdate; }
    // use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    const LABELS = [
        'contract_id' => 'Contrato',
        'due_date' => 'Fecha de vencimiento',
        'amount' => 'Monto Cuota ($)',
        'amount_payment' => 'Monto Pagado ($)',
        'status' => 'Estado',
        'payment_date' => 'Fecha de pago',
        'notes' => 'Observaciones',
        'installment_number' => 'Número de Cuota'
    ];

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Installment::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/installment');
        CRUD::setEntityNameStrings('Cuota', 'Cuotas');

        parent::setup();

        $this->setupListOperation();
        $this->setupShowOperation();
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        $contract_id = $this->crud->getRequest()->contract_id;
        
        if ( $contract_id ) {
            $this->crud->addClause('where', 'contract_id', '=', $contract_id)->orderBy('due_date', 'asc');
        }
        
        $this->crud->removeButton('create');
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');
        $this->crud->addButtonFromView('top', 'volver', 'back_contract_list', 'right');
        CRUD::setOperationSetting('lineButtonsAsDropdown', true);
          
            
        // $this->crud->addColumn([
        //     'name' => 'contract.code', // El nombre del campo en la base de datos o la relación
        //     'label' => self::LABELS['contract_id'], // La etiqueta para la columna
        // ]);

        CRUD::column('installment_number')->label(self::LABELS['installment_number']);
        
        CRUD::column('due_date')->label(self::LABELS['due_date']);
        CRUD::column('amount')->label(self::LABELS['amount']);

        CRUD::column('total_payment_list')->label('Total Pagado');

        CRUD::column('status')
        ->label(self::LABELS['status'])
        ->name('status')
        ->type('enum')
        ->options(Installment::STATUSES)->wrapper([
            'element' => 'span',
            'class' => function($crud, $column, $entry, $related_key){
                if($column['value'] === 'PAID') return 'badge rounded-pill text-bg-success';
                elseif($column['value'] === 'PARTIAL_PAID') return 'badge rounded-pill text-bg-warning';
                elseif($column['value'] === 'ENDING') return 'badge rounded-pill text-bg-warning';
                elseif($column['value'] === 'REJECTED') return 'badge rounded-pill text-bg-danger';
                else return 'badge rounded-pill text-bg-info';
            }
        ]);


        
        $this->crud->addButtonFromModelFunction('line', 'custom_action', 'getPaymentsButton', 'beginning');
        CRUD::addButtonFromView('line', 'payment', 'installment_payment', 'beginning');
        
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(InstallmentRequest::class);
        $this->crud->addField([
            'name' => 'contract.code',
            'label' => self::LABELS['contract_id'],
            'attributes' => [
                'class' => 'form-control',
                'disabled' => true
            ]
        ]);

        // $this->crud->addField([
        //     'name' => 'installment_number',
        //     'label' => 'Número de Cuota',
        //     'type' => 'number',
        //     'attributes' => [
        //         'class' => 'form-control',
        //         'placeholder' => 'Número de Cuota'
        //     ]
        // ]);
        
        $this->crud->addField([
            'name' => 'amount',
            'label' => self::LABELS['amount'],
            'type' => 'text',
            'hint' => 'Monto Otorgado',
            'attributes' => [
            'placeholder' => '150,00 $',
            'class' => 'form-control moneyCalculatorUsd',
            'readonly' => 'readonly'
            ]
        ]);

        $this->crud->addField([
            'name' => 'amount_payment',
            'label' => self::LABELS['amount_payment'],
            'type' => 'text',
            'hint' => 'Monto Pagado',
            'attributes' => [
                'placeholder' => '150,00 $',
                'class' => 'form-control moneyCalculatorUsd'
            ]
        ]);

        $this->crud->addField([
            'name' => 'payment_date',
            'label' => self::LABELS['payment_date'],
            'type' => 'date',
            'hint' => 'Fecha de Pago',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Fecha de Pago'
            ]
        ]);

        $this->crud->addField([
            'name' =>'notes',
            'label' => self::LABELS['notes'],
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

    public function update()
    {
        try {
            Log::info('Update method called');
            $response = $this->traitUpdate();
            Log::info('Update method successful', ['response' => $response]);
            
            return $response;
        } catch (Exception $e) {
            dd($e);
            Log::error('Error in update method', ['error' => $e->getMessage()]);
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    protected function setupShowOperation()
    {
        $this->crud->removeButton('update'); // Remove the edit button
    }    
}
