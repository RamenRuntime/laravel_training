<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CardSet extends Model
{
    use CrudTrait;
   protected $table = 'card_sets';


   protected $fillable = [
       'card_id',
       'set_id',
       'rarity',
       'collector_number',
   ];


   public function card(): BelongsTo
   {
       return $this->belongsTo(Card::class);
   }


   public function set(): BelongsTo
   {
       return $this->belongsTo(Set::class);
   }
}



