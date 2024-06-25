<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ContractRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;
use Backpack\CRUD\app\Library\Widget;
use App\Models\{Client, Contract};
use App\Helpers\Helper;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Carbon\Carbon;

/**
 * Class ContractCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ContractCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation { store as traitStore; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation { destroy as traitDestroy; }
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    const LABELS = [
        'client_id' =>'Cliente',
        'guarantor_id' =>'Fiador',
        'total_amount' =>'Monto',
        'initial_amount' =>'Monto Inicial',
        'initial' =>'Pago Inicial',
        'payment_frequency' =>'Frecuencai del Pago',
        'installments_number' =>'N° de Cuotas',
        'percentage' =>'Porcentage',
        'status' =>'Estado',
        'start_date' =>'Fecha de Inicio',
        'end_date' =>'Fecha Fin',
        'terms' =>'Terminos',
        'notes' =>'Notas',
        'payment_day_of_week' => 'Dia de Pago'
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
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        Widget::add()->type('script')->content('/js/admin/lists/contract.js');
        CRUD::setOperationSetting('lineButtonsAsDropdown', true);
        $this->crud->removeButton('update');
        $this->crud->removeButton('delete');
        CRUD::column('start_date')->label(self::LABELS['start_date']);
        CRUD::column('client_id')->label(self::LABELS['client_id']);
        CRUD::column('guarantor_id')->label(self::LABELS['guarantor_id']);
        CRUD::column('total_amount')->label(self::LABELS['total_amount'])->suffix('$')->priority(1);
        
        CRUD::column('percentage')->label(self::LABELS['percentage'])->suffix('%')->priority(1);
        CRUD::column('installments_number')->label(self::LABELS['installments_number']);
        
        CRUD::column('payment_frequency')
        ->label(self::LABELS['payment_frequency'])
        ->name('payment_frequency')
        ->type('enum')
        ->options([
            'WEEKLY' => 'Semanal',
            'FORTNIGHTLY'  => 'Quincenal',
            'MONTHLY' => 'Mensual'
        ]);

        CRUD::addColumn([
            'name' => 'payment_day_of_week',
            'label' => self::LABELS['payment_day_of_week'],
            'type' => 'closure',
            'function' => function($entry) {
                return ucfirst(Carbon::create()->dayOfWeek($entry->payment_day_of_week)->locale('es')->dayName);
            }
        ]);
        

        CRUD::column('status')
        ->label(self::LABELS['status'])
        ->name('status')
        ->type('enum')
        ->options([
            'APPROVED' => 'Aprobado',
            'REJECTED'  => 'Rechazado',
            'ENDING' => 'Finalizado'
        ])->wrapper([
            'element' => 'span',
            'class' => function($crud, $column, $entry, $related_key){
                if($column['value'] === 'APPROVED') return 'badge rounded-pill text-bg-success';
                elseif($column['value'] === 'ENDING') return 'badge rounded-pill text-bg-warning';
                elseif($column['value'] === 'REJECTED') return 'badge rounded-pill text-bg-danger';
                else return 'badge rounded-pill text-bg-info';
            }
        ]);

         CRUD::column('start_date')->label(self::LABELS['start_date']);
         CRUD::column('end_date')->label(self::LABELS['end_date']);

         CRUD::addButtonFromView('line', 'installments', 'contract_installments', 'beginning');

         $this->crud->addButtonFromModelFunction('line', 'custom_action', 'getEditButton', 'beginning');

         $this->crud->addButtonFromModelFunction('line', 'custom_action', 'getDeleteButton', 'beginning');
    
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        Widget::add()->type('script')->content('/packages/decimal/decimal-light.js');
        Widget::add()->type('script')->content('/js/admin/forms/contract.js');

        CRUD::setValidation(ContractRequest::class);

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
            'allows_null' => true,
            'default' => 'Seleccione'
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

        $this->crud->addField([
            'name' => 'start_date',
            'label' => self::LABELS['start_date'],
            'type' => 'date',
            'hint' => 'Fecha de Inicio',
            'attributes' => [
                'class' => 'form-control',
                'placeholder' => 'Fecha de Inicio'
            ]
        ]);

        $this->crud->addField([
            'name' => 'total_amount',
            'label' => self::LABELS['total_amount'],
            'type' => 'text',
            'hint' => 'Monto Otorgado',
            'attributes' => [
                'placeholder' => '150,00 $',
                'class' => 'form-control moneyCalculatorUsd'
            ]
        ]);

        CRUD::addField([
            'name' => 'initial_amount',
            'type' => 'custom_html',
            'label' => 'Monto Inicial',
            'value' =>'',
        ]);

        CRUD::addField([
            'name' => 'profit',
            'type' => 'custom_html',
            'label' => 'Ganancia Estimda',
            'value' =>'',
        ]);

        // CRUD::addField([
        //     'name' => 'converted_amount',
        //     'type' => 'custom_html',
        //     'label' => 'Monto Inicial',
        //     'value' =>'',
        // ]);

        $this->crud->addField([
            'name' => 'percentage',
            'label' => self::LABELS['percentage'],
            'type' => 'text',
            'hint' => 'Porcentaje de Interes',
            'attributes' => [
                'placeholder' => '40,00 %',
                'class' => 'form-control moneyPercentaje'
            ]
        ]);        

        $this->crud->addField([
            'name' => 'installments_number',
            'label' => self::LABELS['installments_number'],
            'type' => 'number',
            'hint' => 'Numero de Cuotas'
        ]);

        $this->crud->addField([
            'name' => 'initial',
            'label' => self::LABELS['initial'],
            'type' => 'text',
            'hint' => 'Monto Inicial',
            'attributes' => [
                'placeholder' => '25,00 $',
                'class' => 'form-control moneyCalculatorUsd'
            ]
        ]);

        $this->crud->addField([
            'name' => 'payment_frequency',
            'label' => self::LABELS['payment_frequency'],
            'type' => 'select_from_array',
            'options' => [
                'WEEKLY' => 'Semanal',
                'FORTNIGHTLY' => 'Quincenal',
                'MONTHLY' =>'Mensual'
            ],
            'allows_null' => false,
            'default' => 'WEEKLY'
        ]);

        $this->crud->addField([
            'name' => 'payment_day_of_week',
            'label' => 'Dia de Pago',
            'type' => 'select_from_array',
            'options' => [
                0 => 'Domingo',
                1 => 'Lunes',
                2 => 'Martes',
                3 => 'Miercoles',
                4 => 'Jueves',
                5 => 'Viernes',
                6 => 'Sabado'
            ],
            'allows_null' => true,
            'wrapperAttributes' => [
                'class' => 'form-group col-md-12 payment_day_of_week'
            ]
        ]);

        $this->crud->addField([
            'name' =>'terms',
            'label' => self::LABELS['terms'],
            'type' => 'summernote',
            'hint' => 'Terminos del Contrato',
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
                'placeholder' => 'Terminos del Contrato'
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

    public function store()
    {
        $client = Client::find($this->crud->getRequest()->client_id);
        $next_code = Contract::NextCode($client?->code);
        $totalAmount = (Float) Helper::formatAmount($this->crud->getRequest()->total_amount);
        $initial = $this->crud->getRequest()->initial ?? 0.00;
        $percentage = (Float) Helper::formatAmount($this->crud->getRequest()->percentage);
        $initialAmount = $totalAmount / (1 + $percentage / 100);
        $profit = $totalAmount - $initialAmount;
        // dd($totalAmount, $initialAmount, $percentage, $profit);

        $this->crud->addField(['type' => 'hidden', 'name' => 'code']);
        $this->crud->addField(['type' => 'hidden', 'name' => 'profit']);
        $this->crud->addField(['type' => 'hidden', 'name' => 'initial_amount']);
        $this->crud->getRequest()->request->add([
                'initial_amount' => $initialAmount,
                'total_amount'   => $totalAmount,
                'percentage' => $percentage,
                'initial' => Helper::formatAmount($initial),
                'code' => $next_code,
                'profit' => $profit
        ]);
            
        try {
            $response = DB::transaction(function () use($next_code) {
                
                $response = $this->traitStore();
                

                return $response;

            });

            session()->flash('alert-success', $next_code.' Contrato agregado con exito!');

            return $response;

        } catch (\Throwable $e) {
            Log::error("ERROR AL GENERAR CUOTAS DEL CONTRATO");
            Log::error($e->getMessage());
            throw $e;
            return redirect()->back()->withInput()->withErrors( $e->errors());
            
        }
       
    }

    public function destroy($id)
    {
        $contract = Contract::findOrFail($id);

        // Chequear si todas las cuotas están en estado PENDING
        if ($contract->allPending()) {
            try {
                // Eliminar todas las cuotas asociadas
                $contract->installments()->delete();

                $response = $this->traitDestroy($id);
                session()->flash('alert-success', 'Contrato eliminado con exito!');
                return $response;
            } catch (\Throwable $e) {
                Log::error("ERROR AL ELIMINAR CONTRATO");
                Log::error($e->getMessage());
                throw $e;
                return redirect()->back()->withInput()->withErrors( $e->errors());
            }
        }else{
            session()->flash('alert-danger', 'No se puede eliminar el contrato, existen cuotas pagadas o en proceso!');
            return redirect()->back();
        }
    }
}
