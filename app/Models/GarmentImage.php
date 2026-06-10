<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

class GarmentImage extends Model
{
    protected $fillable = [
        'image_path',
        'original_filename',
        'ai_description',
        'garment_type',
        'style',
        'material',
        'color_palette',
        'pattern',
        'season',
        'occasion',
        'consumer_profile',
        'trend_notes',
        'continent',
        'country',
        'city',
        'captured_year',
        'captured_month',
        'designer',
        'raw_ai_response',
    ];

    //Cast fields into PHP Types
    protected $casts = [
        'captured_year' => 'integer',
        'captured_month' => 'integer',
        'raw_ai_response' => 'array',
    ];

    public function annotations(): HasMany
    {
        return $this->hasMany(Annotation::class);
    }
}
