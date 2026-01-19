<?php


namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;


class Card extends Model
{
    use CrudTrait;
   protected $table = 'cards';


   protected $fillable = [
       'name',
       'mana_cost',
       'cmc',
       'type_line',
       'colors',
       'oracle_text',
       'legalities',
   ];


   protected $casts = [
       'cmc' => 'integer',
       'colors' => 'array',   
       'legalities' => 'array',
   ];


   public function sets(): BelongsToMany {
       return $this->belongsToMany(Set::class, 'card_sets', 'card_id', 'set_id')
           ->withPivot(['id', 'rarity', 'collector_number'])
           ->withTimestamps();
   }
}



