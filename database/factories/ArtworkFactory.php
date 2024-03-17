<?php

namespace Database\Factories;

use App\Models\Image;
use App\Models\Classification;
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
            'title' => $this->faker->word(),
            'image_id' => Image::all()->random()->id,
            'public_id' => $this->faker->uuid(),
            'description' => $this->faker->text(400),
            'classification_id' => Classification::all()->random()->id,
            'technique' => $this->faker->text(255),
            'details' => $this->faker->text(255),
            'measures' => $this->faker->text(100),
        ];
    }
}
