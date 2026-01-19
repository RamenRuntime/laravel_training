<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CardSetRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CardSetCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CardSetCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    /**
     * Configure the CrudPanel object. Apply settings to all operations.
     * 
     * @return void
     */
    public function setup()
    {
        CRUD::setModel(\App\Models\CardSet::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/card-set');
        CRUD::setEntityNameStrings('card set', 'card sets');
    }

    /**
     * Define what happens when the List operation is loaded.
     * 
     * @see  https://backpackforlaravel.com/docs/crud-operation-list-entries
     * @return void
     */
    protected function setupListOperation()
    {
        // CRUD::setFromDb(); // set columns from db columns.

        /**
         * Columns can be defined using the fluent syntax:
         * - CRUD::column('price')->type('number');
         */
        CRUD::addColumn([
            'name'      => 'card_id',
            'label'     => 'Card',
            'type'      => 'select',
            'entity'    => 'card',
            'attribute' => 'name',
            'model'     => \App\Models\Card::class,
        ]);
    
        CRUD::addColumn([
            'name'      => 'set_id',
            'label'     => 'Set',
            'type'      => 'select',
            'entity'    => 'set',
            'attribute' => 'set_name',
            'model'     => \App\Models\Set::class,
        ]);
    
        CRUD::column('rarity');
        CRUD::column('collector_number');
        CRUD::column('updated_at');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CardSetRequest::class);
        // CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */

        CRUD::addField([
            'label'     => 'Card',
            'type'      => 'select2',
            'name'      => 'card_id',
            'entity'    => 'card',
            'attribute' => 'name',
            'model'     => \App\Models\Card::class,
        ]);
    
        CRUD::addField([
            'label'     => 'Set',
            'type'      => 'select2',
            'name'      => 'set_id',
            'entity'    => 'set',
            'attribute' => 'set_name',
            'model'     => \App\Models\Set::class,
        ]);
    
        CRUD::field('rarity');
        CRUD::field('collector_number');
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
