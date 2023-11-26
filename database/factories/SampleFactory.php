<?php

namespace Database\Factories;

use App\Models\Crop;
use App\Models\Sample;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\DB;

class SampleFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Sample::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'code' => $this->faker->regexify('ABC[A-Z0-9]{3}'),
            'crop_id' => Crop::inRandomOrder()->first()->id,
        ];
    }
}
