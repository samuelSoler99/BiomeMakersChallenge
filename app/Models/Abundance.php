<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * The abundance that connects a sample with an organism
 * @property int $num
 * @property Sample $sample
 * @property Organism $organism
 */
class Abundance extends Model
{
    use HasFactory;
    public function sample(){
        return $this->belongsTo(Sample::class);
    }

    public function organism(){
        return $this->belongsTo(Organism::class);
    }

}
