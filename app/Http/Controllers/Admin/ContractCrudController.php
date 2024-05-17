<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContractRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use App\Models\Client;

/**
 * Class ContractCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContractCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;
    const LABELS = [
        'client_id' =>'Cliente',
        'guarantor_id' =>'Fiador',
        'amount' =>'Monto',
        'payment_frequency' =>'Frecuencai del Pago',
        'installments' =>'N° de Cuotas',
        'percentage' =>'Porcentage',
        'status' =>'Estado',
        'start_date' =>'Fecha de Inicio',
        'end_date' =>'Fecha Fin',
        'terms' =>'Terminos',
        'notes' =>'Notas',
    ];

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Contract::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/contract');
        CRUD::setEntityNameStrings('Contrato', 'Contratos');

        Widget::add()->type('script')->content('/js/select2.js.js');
        // Widget::add()->type('link')->content('/css/select2.css');
        
// <link href="{{ asset('/css/select2.css') }}" rel="stylesheet" />
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ContractRequest::class);

        $clientsOptions = Client::getOptions();
        
        // CRUD::addField([
        //     'name' => 'client_id',
        //     'label' => self::LABELS['client_id'],
        //     'type' => 'select_from_array',
        //     'entity' => 'client',
        //     'attribute' => 'name_code',
        //     'model' => "App\Models\Client",
        //     'options' => ['' => 'Seleccione'] + $clientsOptions
        // ]);
        
        $this->crud->addField([
            'label' => "Cliente", // Etiqueta para el campo
            'type' => 'select', // Tipo de campo
            'name' => 'client_id', // El nombre del campo en la base de datos
            'entity' => 'client', // El método que define la relación en tu Modelo
            'attribute' => 'name_code', // El atributo que se mostrará en el select
            'model' => "App\Models\Client",
            'attributes' => [
                'class' => 'form-control select2'
            ],
        ]);

        $this->crud->addField([
            'label' => self::LABELS['guarantor_id'], // Etiqueta para el campo
            'name' => 'guarantor_id', // El nombre del campo en la base de datos
            'type' => 'select', // Tipo de campo
            'entity' => 'client', // El método que define la relación en tu Modelo
            'attribute' => 'name_code', // El atributo que se mostrará en el select
            'model' => "App\Models\Client", 
            'attributes' => [
                'class' => 'form-control select2'
            ],
        ]);

        // CRUD::addField([
        //     'name' => 'guarantor_id',
        //     'label' => self::LABELS['guarantor_id'],
        //     'type' => 'select_from_array',
        //     'entity' => 'client',
        //     'attribute' => 'name',
        //     'model' => "App\Models\Client",
        //     'options' => ['' => 'Seleccione'] + $clientsOptions
        // ]);
        

        $this->crud->addField([
            'name' => 'amount',
            'label' => self::LABELS['amount'],
            'type' => 'text',
            'hint' => 'Monto de la Recarga',
            'attributes' => [
                'placeholder' => '25$',
                'class' => 'form-control moneyNumber'
            ]
        ]);

        $this->crud->addField( [
            'name' => 'payment_frequency',
            'label' => self::LABELS['payment_frequency'],
            'type'  => 'enum',
            'options' => [
                '' =>'Seleccione',
                'fortnightly' => 'Quincenal',
                'monthly' => 'Mensual'
            ]
        ]);

        $this->crud->addField([
            'name' => 'installments',
            'label' => self::LABELS['installments'],
            'type' => 'number',
            'hint' => 'Numero de Cuotas'
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
}
