<?php

namespace Database\Factories;

use App\Models\Crop;
use Illuminate\Database\Eloquent\Factories\Factory;

class CropFactory extends Factory
{
    protected $model = Crop::class;

    public function definition()
    {
        return [
            'name' => $this->faker->word,
            'type' => $this->faker->word,
            'variety' => $this->faker->word,
            'planting_date' => $this->faker->date(),
            'address' => $this->faker->address,
        ];
    }
}


