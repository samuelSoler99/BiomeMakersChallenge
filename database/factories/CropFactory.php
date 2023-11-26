<?php

namespace Database\Factories;

use App\Models\Crop;
use Illuminate\Database\Eloquent\Factories\Factory;

class CropFactory extends Factory
{
    protected $model = Crop::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
