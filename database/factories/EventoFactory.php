<?php

namespace Database\Factories;

use App\Models\Evento;
use Illuminate\Support\Arr;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Evento>
 */
class EventoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'titulo' => Arr::random([
                'Culto domingo de manhã',
                'Culto domingo à noite',
                'Culto de quinta feira',
                'Culto de oração',
                'Culto de missões',
            ]),
            'descricao' => Arr::random([
                ...json_decode('[' . str_repeat('null, ', 10) . 'null ]', \true),
                'Culto ministrado pelo pr. ' . \fake('pt_BR')->name(),
                'Culto ministrado pelo miss. ' . \fake('pt_BR')->name(),
            ]),
            'previsao_inicio' => fn ($attr) => str_contains($attr['titulo'], 'manhã')
                ? now()->parse('09:00')->subDays()
                : now()->parse('19:00')->subDays(),
            'previsao_fim' => fn ($attr) => now()->parse($attr['previsao_inicio'])->addHours(1),
            'data_inicio' => \null,
            'data_fim' => \null,
            'nota_interna' => \null,
            'status_enum' => Arr::random([
                ...str_split(str_repeat(
                    (string) Evento::STATUS_A_REALIZAR,
                    10
                )),
                Evento::STATUS_REALIZADO,
                Evento::STATUS_NAO_REALIZADO,
                Evento::STATUS_CANCELADO,
                Evento::STATUS_DESCONHECIDO,
            ]),
        ];
    }
}
