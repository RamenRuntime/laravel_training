<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Set extends Model
{
    use CrudTrait;
   protected $table = 'sets';


   protected $fillable = [
       'set',
       'set_name',
   ];


   public function cards(): BelongsToMany
   {
       return $this->belongsToMany(Card::class, 'card_sets', 'set_id', 'card_id')
           ->withPivot(['id', 'rarity', 'collector_number'])
           ->withTimestamps();
   }
}



