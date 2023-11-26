<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * A sample
 * @property string $code The code to identify the sample
 */
class Sample extends Model
{
    use HasFactory;

    /**
     * @return HasMany
     */
    public function abundances(): HasMany
    {
        return $this->hasMany(Abundance::class);
    }

    /**
     * @return BelongsTo
     */
    public function crop(): BelongsTo
    {
        return $this->belongsTo(Crop::class);
    }
}
