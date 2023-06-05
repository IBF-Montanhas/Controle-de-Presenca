<?php

namespace Database\Factories;

use App\Models\Evento;
use App\Models\Membro;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MembroEvento>
 */
class MembroEventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'evento_id' => Evento::factory(),
            'membro_id' => Membro::factory(),
            'nota_interna' => \null,
            'presente' => \null,
        ];
    }
}
