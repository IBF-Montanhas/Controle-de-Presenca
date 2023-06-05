<?php

namespace Database\Seeders;

use App\Models\Evento;
use App\Models\MembroEvento;
use Illuminate\Database\Seeder;

class EventoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Evento::factory(4)->afterCreating(function (Evento $evento) {
            MembroEvento::factory(10)->create(['evento_id' => $evento->id]);
        })->create();
    }
}
