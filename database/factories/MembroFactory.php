<?php

namespace Database\Factories;

use App\Models\Membro;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Membro>
 */
class MembroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $sexos = [
            'm' => 'male',
            'f' => 'female',
        ];

        return  [
            'sexo' => Arr::random(['f', 'm']),
            'nome' => fn ($attr) => \fake('pt_BR')->name($sexos[$attr['sexo']] ?? 'm'),
            'sobrenome' => \fake('pt_BR')->lastName(),
            'nome_amigavel' => \null,
            'status_enum' => Arr::random([
                Membro::STATUS_INATIVO,
                Membro::STATUS_ATIVO,
            ]),
            'tipo_enum' => Arr::random([
                Membro::TIPO_INDEFINIDO,
                Membro::TIPO_MEMBRO,
                Membro::TIPO_CRIANCA,
                Membro::TIPO_ADOLESCENTE,
                Membro::TIPO_VISITANTE,
            ]),
            'data_de_nascimento' => Arr::random([
                now()->subYears(rand(15, 80)),
                now()->subMonths(rand(5, 25))->subYears(rand(15, 80)),
                now()->addDays(rand(1, 25))->subYears(rand(15, 80)),
                now()->addDays(rand(1, 25))->subYears(rand(15, 80)),
            ]),
            'membro_desde' => now()->subMonths(rand(5, 25)),
            'primeiro_registro' => \null,
            'nota_publica' => \null,
            'nota_interna' => \null,
            'telefones' => rand(1, 50) ? [
                [
                    'numero' => \fake()->numerify('(##) 9####-####'),
                    'descricao' => 'Pessoal',
                    'wa' => (bool) rand(0, 1),
                    'telegram' => (bool) rand(0, 1),
                ],
                [
                    'numero' => \fake()->numerify('(##) 3###-####'),
                    'descricao' => 'Trabalho',
                    'wa' => (bool) rand(0, 1),
                    'telegram' => (bool) rand(0, 1),
                ],
            ] : [],
        ];
    }
}
