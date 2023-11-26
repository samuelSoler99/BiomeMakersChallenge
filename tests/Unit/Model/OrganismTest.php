<?php

namespace Tests\Unit\Model;

use App\Models\Abundance;
use App\Models\Crop;
use App\Models\Organism;
use App\Models\Sample;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrganismTest extends TestCase
{
    /*todo use a test database so dont reset the real one */
    use RefreshDatabase;

    public function testGetTopOrganismsWithCrops()
    {
        $organism2 = Organism::factory()->create();
        $organism1 = Organism::factory()->create();

        $crop1 = Crop::factory()->create();
        $crop2 = Crop::factory()->create();
        $crop3 = Crop::factory()->create();
        $crop4 = Crop::factory()->create();


        $sample1 = Sample::factory()->create(['code' => 'code', 'crop_id' => $crop1->id]);
        $sample2 = Sample::factory()->create(['code' => 'code', 'crop_id' => $crop1->id]);
        $sample3 = Sample::factory()->create(['code' => 'code', 'crop_id' => $crop2->id]);
        $sample4 = Sample::factory()->create(['code' => 'code', 'crop_id' => $crop2->id]);
        $sample5 = Sample::factory()->create(['code' => 'code', 'crop_id' => $crop3->id]);
        $sample6 = Sample::factory()->create(['code' => 'code', 'crop_id' => $crop3->id]);
        $sample7 = Sample::factory()->create(['code' => 'code', 'crop_id' => $crop4->id]);

        Abundance::factory()->create(['sample_id' => $sample1->id, 'organism_id' => $organism1->id]);
        Abundance::factory()->create(['sample_id' => $sample2->id, 'organism_id' => $organism1->id]);
        Abundance::factory()->create(['sample_id' => $sample3->id, 'organism_id' => $organism2->id]);
        Abundance::factory()->create(['sample_id' => $sample4->id, 'organism_id' => $organism1->id]);
        Abundance::factory()->create(['sample_id' => $sample5->id, 'organism_id' => $organism1->id]);
        Abundance::factory()->create(['sample_id' => $sample6->id, 'organism_id' => $organism1->id]);
        Abundance::factory()->create(['sample_id' => $sample7->id, 'organism_id' => $organism1->id]);


        $result = $organism1->getTopOrganismsWithCrops();
        $this->assertInstanceOf(Collection::class, $result);


        $this->assertCount(2, $result);

        $topOrganism = $result[0];

        $this->assertEquals($organism1->id, $topOrganism->id, 'the top organism must be the organism 1');
        $this->assertEquals($organism1->genus, $topOrganism->genus, 'the top organism must be the organism 1');
        $this->assertEquals($organism1->species, $topOrganism->species, 'the top organism must be the organism 1');
        $this->assertEquals(6, $topOrganism->sample_count, 'has 6 samples');
        $this->assertCount(3, $topOrganism->top_crops, 'has 3 crops');
        $this->assertCount(3, $topOrganism->top_crops, 'has 3 crops');
    }
}
