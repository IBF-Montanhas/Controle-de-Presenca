<?php

namespace Database\Factories;

use App\Models\Setting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Setting>
 */
class SettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'site_id' => \null,
            'key' => str(\fake()->words(3, true))->replace(['  ', '.'], ' ')->replace(' ', '.')->trim()->toString(),
            'name' => fn ($attr) => str($attr['key'])->replace('.', ' ')->trim()->ucFirst()->toString(),
            'type' => Setting::TYPE_STRING,
            'value_when_string' => \fake()->words(4, true),
            'active' => (bool) \rand() % 2,
            'can_be_deleted' => (bool) (\rand(1, 10) % 3),
        ];
    }
}
