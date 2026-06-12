<?php

namespace Tests\Feature;

use App\Models\GarmentImage;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class GarmentFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_itFiltersGarmentsByCountryAndYear(): void
    {
        GarmentImage::create([
            'image_path' => 'garments/canada-blouse.jpg',
            'original_filename' => 'canada-blouse.jpg',
            'ai_description' => 'Visible Canadian embroidered neckline reference.',
            'garment_type' => 'Blouse',
            'style' => 'Bohemian',
            'material' => 'Cotton',
            'season' => 'Summer',
            'occasion' => 'Casual',
            'country' => 'Canada',
            'city' => 'Toronto',
            'captured_year' => 2026,
            'captured_month' => 6,
            'designer' => 'Gabriel',
        ]);

        GarmentImage::create([
            'image_path' => 'garments/us-jacket.jpg',
            'original_filename' => 'us-jacket.jpg',
            'ai_description' => 'New York denim utility jacket reference.',
            'garment_type' => 'Jacket',
            'style' => 'Streetwear',
            'material' => 'Denim',
            'season' => 'Fall',
            'occasion' => 'Everyday',
            'country' => 'United States',
            'city' => 'New York',
            'captured_year' => 2025,
            'captured_month' => 9,
            'designer' => 'Maria',
        ]);

        $response = $this->get('/?country=Canada&captured_year=2026');

        $response->assertOk();
        $response->assertSeeText('Visible Canadian embroidered neckline reference.');
        $response->assertDontSeeText('New York denim utility jacket reference.');
    }

    public function test_itSearchesAcrossDesignerAnnotations(): void
    {
        $garment = GarmentImage::create([
            'image_path' => 'garments/annotation-test.jpg',
            'original_filename' => 'annotation-test.jpg',
            'ai_description' => 'Simple garment description.',
            'garment_type' => 'Dress',
            'style' => 'Resort',
            'material' => 'Linen',
            'season' => 'Summer',
            'occasion' => 'Vacation',
            'country' => 'Mexico',
            'city' => 'Chihuahua',
            'captured_year' => 2026,
            'captured_month' => 4,
            'designer' => 'Gabriel',
        ]);

        $garment->annotations()->create([
            'tags' => 'artisan neckline capsule',
            'notes' => 'Could inspire a resort blouse.',
            'observations' => 'Strong warm-weather reference.',
        ]);

        $response = $this->get('/?search=artisan neckline');

        $response->assertOk();
        $response->assertSee('Simple garment description.');
    }
}
