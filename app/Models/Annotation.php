<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Annotation extends Model
{
    protected $fillable = [
        'garment_image_id',
        'tags',
        'notes',
        'observations',
    ];

    public function garmentImage(): BelongsTo
    {
        return $this->belongsTo(GarmentImage::class);
    }
}
