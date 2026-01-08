<?php


use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


return new class extends Migration
{
   /**
    * Run the migrations.
    */
   public function up(): void
   {
       Schema::create('card_sets', function (Blueprint $table) {
           $table->id();
           $table->timestamps();
           $table->string('rarity', 30)->nullable();
           $table->string('collector_number', 20)->nullable();


           $table->foreignId('card_id')
               ->constrained('cards')
               ->cascadeOnDelete();


           $table->foreignId('set_id')
               ->constrained('sets')
               ->cascadeOnDelete();


           $table->unique(['card_id', 'set_id']);           
       });
   }


   /**
    * Reverse the migrations.
    */
   public function down(): void
   {
       Schema::dropIfExists('card_sets');
   }
};



