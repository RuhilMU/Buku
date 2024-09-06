<?php

namespace Database\Seeders;

use App\Models\Maha;
use Illuminate\Database\Seeder;

class MahaSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 0; $i < 10; $i++) {
            Maha::create([
                'nama' => fake()->name(),
                'nim' => fake()->number_format(6),
                'jurusan' => fake()->sentence(3),
                'angkatan' => fake()->numberBetween(20, 24),
            ]);
        }
    }
}