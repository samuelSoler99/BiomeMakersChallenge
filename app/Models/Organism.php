<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * An organism
 * @property string $genus
 * @property string $species
 */
class Organism extends Model
{
    protected $table = 'organisms';
    protected $fillable = ['genus', 'species'];

    use HasFactory;

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getTopOrganismsWithCrops(): \Illuminate\Support\Collection
    {
        return $this->select('organisms.*', DB::raw('COUNT(samples.id) as sample_count'))
            ->leftJoin('abundances', 'organisms.id', '=', 'abundances.organism_id')
            ->leftJoin('samples', 'abundances.sample_id', '=', 'samples.id')
            ->groupBy('organisms.id')
            ->orderByDesc('sample_count')
            ->limit(10)
            ->get()
            ->map(function ($organism) {
                $organism->top_crops = $organism->getTopCrops();
                return $organism;
            });
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function getTopCrops(): \Illuminate\Support\Collection
    {
        return DB::table('abundances')
            ->select('crops.name', DB::raw('COUNT(abundances.sample_id) as sample_count'))
            ->join('samples', 'abundances.sample_id', '=', 'samples.id')
            ->join('crops', 'samples.crop_id', '=', 'crops.id')
            ->where('abundances.organism_id', '=', $this->id)
            ->groupBy('crops.id')
            ->orderByDesc('sample_count')
            ->limit(3)
            ->get();
    }
}
