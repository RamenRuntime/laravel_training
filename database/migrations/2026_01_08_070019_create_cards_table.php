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
        Schema::create('cards', function (Blueprint $table) {

            $table->id();
            $table->string('name', 150)->unique();
            $table->string('mana_cost', 30)->nullable();
            $table->integer('cmc')->nullable();
            $table->string('type_line', 300)->nullable();
            $table->json('colors')->nullable();
            $table->text('oracle_text')->nullable();
            $table->json('legalities')->nullable();
            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};

