<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Artwork>
 */
class ArtworkFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->text,
            'classification' => $this->faker->randomElement(['Pintura', 'Escultura', 'Dibujo', 'Artesanía', 'Grabado', 'Cerámica', 'Orfebrería']),
            'technique' => $this->faker->sentence,
            'details' => $this->faker->text,
            'measures' => $this->faker->sentence,
        ];
    }
}
