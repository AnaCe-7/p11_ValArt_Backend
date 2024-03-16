<?php

namespace Database\Seeders;
use App\Models\Classification;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClassificationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Classification::create(['name' => 'Pintura']);
        Classification::create(['name' => 'Escultura']);
        Classification::create(['name' => 'Dibujo']);
        Classification::create(['name' => 'Artesanía']);
        Classification::create(['name' => 'Grabado']);
        Classification::create(['name' => 'Cerámica']);
        Classification::create(['name' => 'Orfebrería']); 
    }
}
