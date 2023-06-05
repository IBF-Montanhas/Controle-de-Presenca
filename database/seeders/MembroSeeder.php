<?php

namespace Database\Seeders;

use App\Models\Membro;
use Illuminate\Database\Seeder;

class MembroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Membro::factory(25)->create();
    }
}
