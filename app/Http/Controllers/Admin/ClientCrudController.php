<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\ClientRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class ClientCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class ClientCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    const LABELS = [
        'code' => 'Código Cliente',
        'dni' => 'Cédula de Identidad',
        'names' => 'Nombres',
        'last_names' => 'Apellidos',
        'direction' => 'Dirección',
        'phone' => 'Teléfono',
        'email' => 'Correo',
        'active' => 'Activo',
        'created_at' => 'Fecha registro',
    ];

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\Client::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/client');
        CRUD::setEntityNameStrings('Cliente', 'Clientes');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        CRUD::column('code')->label(self::LABELS['code']);
        CRUD::column('dni')->label(self::LABELS['dni']);
        CRUD::column('names')->label(self::LABELS['names']);
        CRUD::column('last_names')->label(self::LABELS['last_names']);
        CRUD::column('phone')->label(self::LABELS['phone']);
        CRUD::column('active')->label(self::LABELS['active']);
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(ClientRequest::class);
        //CRUD::setFromDb(); // set fields from db columns.
        
        CRUD::field('code')
            ->label(self::LABELS['code'])
            ->attributes([
                'placeholder' => 'Escriba aquí el códido del cliente  '
            ]);
        
        CRUD::field('dni')
            ->label(self::LABELS['dni'])
            ->attributes([
                'placeholder' => 'Escriba aquí la Cédula de Identidad del Cliente  '
            ]);

        CRUD::field('names')->label(self::LABELS['names'])
            ->attributes([
                'placeholder' => 'Nombres del Cliente'
            ]);

        CRUD::field('last_names')->label(self::LABELS['last_names'])
        ->attributes([
            'placeholder' => 'Apellidos del Cliente'
        ]);    

        CRUD::field('phone')->label(self::LABELS['phone'])
        ->attributes([
            'class' => 'form-control phoneNumber',
        ]);

        CRUD::field('email')->label(self::LABELS['email']);

        CRUD::field('direction')
            ->label(self::LABELS['direction'])
            ->type('textarea')
            ->attributes([
                'placeholder' => 'Escriba aquí su dirección Completa'
            ]);

        CRUD::field('active')
            ->label(self::LABELS['active'])
            ->type('switch')
            ->color('primary')
            ->onLabel('✓')
            ->offLabel('✕')
            ->default(true);


        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */
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
