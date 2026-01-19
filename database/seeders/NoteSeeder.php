<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Note;

class NoteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Note::query()->create([
            'title' => 'Primera nota',
            'body' => 'Nota de prueba para Backpack.',
            'is_published' => true,
        ]);

        Note::query()->create([
            'title' => 'Borrador',
            'body' => null,
            'is_published' => false,
        ]);
    }
}
