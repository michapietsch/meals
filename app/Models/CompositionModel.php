<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CompositionModel extends Model
{
    use HasFactory;

    protected $table = 'composition';

    protected $guarded = [];

    public function composable(): MorphTo
    {
        return $this->morphTo();
    }
}
