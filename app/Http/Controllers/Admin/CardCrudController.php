<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\CardRequest;
use Backpack\CRUD\app\Http\Controllers\CrudController;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

/**
 * Class CardCrudController
 * @package App\Http\Controllers\Admin
 * @property-read \Backpack\CRUD\app\Library\CrudPanel\CrudPanel $crud
 */
class CardCrudController extends CrudController
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
        CRUD::setModel(\App\Models\Card::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/card');
        CRUD::setEntityNameStrings('card', 'cards');
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

        CRUD::column('name')->label('Name');
        CRUD::column('mana_cost')->label('Mana cost');
        CRUD::column('cmc')->label('CMC');
        CRUD::column('type_line')->label('Type');
        CRUD::column('updated_at')->label('Updated');
    }

    /**
     * Define what happens when the Create operation is loaded.
     * 
     * @see https://backpackforlaravel.com/docs/crud-operation-create
     * @return void
     */
    protected function setupCreateOperation()
    {
        CRUD::setValidation(CardRequest::class);
        // CRUD::setFromDb(); // set fields from db columns.

        /**
         * Fields can be defined using the fluent syntax:
         * - CRUD::field('price')->type('number');
         */

        CRUD::field('name')->label('Name');

        CRUD::addField([
            'name'  => 'mana_cost',
            'type'  => 'text',
            'label' => 'Mana cost',
            'attributes' => ['placeholder' => '{U}{U}'],
        ]);

        CRUD::addField([
            'name'  => 'cmc',
            'type'  => 'number',
            'label' => 'CMC',
            'attributes' => ['min' => 0, 'step' => 1],
        ]);

        CRUD::addField([
            'name'  => 'type_line',
            'type'  => 'text',
            'label' => 'Type line',
            'attributes' => ['placeholder' => 'Instant'],
        ]);

        CRUD::addField([
            'name'  => 'oracle_text',
            'type'  => 'textarea',
            'label' => 'Oracle text',
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

    protected function setupShowOperation(){
        CRUD::column('name')->label('Name');
        CRUD::column('mana_cost')->label('Mana cost');
        CRUD::column('cmc')->label('CMC');
        CRUD::column('type_line')->label('Type');
        CRUD::column('oracle_text')->type('textarea')->label('Oracle text');
    
        CRUD::column('created_at')->label('Created');
        CRUD::column('updated_at')->label('Updated');
    }
}
