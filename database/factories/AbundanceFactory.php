<?php

namespace Database\Factories;

use App\Models\Abundance;
use App\Models\Organism;
use App\Models\Sample;
use Illuminate\Database\Eloquent\Factories\Factory;

class AbundanceFactory extends Factory
{
    /**
     * @var string
     */
    protected $model = Abundance::class;

    /**
     * @return array
     */
    public function definition(): array
    {
        $sample = Sample::inRandomOrder()->first();
        $organism = Organism::inRandomOrder()->first();

        return [
            'sample_id' => $sample->id,
            'organism_id' => $organism->id,
            'num' => $this->faker->numberBetween(1, 100), // Puedes ajustar esto según tus necesidades
        ];
    }
}
