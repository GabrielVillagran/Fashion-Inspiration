<?php

namespace Database\Seeders;

use App\Models\GarmentImage;
use Illuminate\Database\Seeder;

class GarmentImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $samples = [
            [
                'image_path' => 'garments/sample-blouse.jpg',
                'original_filename' => 'sample-blouse.jpg',
                'ai_description' => 'A relaxed white cotton blouse with embroidered neckline details, natural fibers, and artisan-inspired finishing.',
                'garment_type' => 'Blouse',
                'style' => 'Bohemian',
                'material' => 'Cotton',
                'color_palette' => 'White, beige',
                'pattern' => 'Embroidered',
                'season' => 'Summer',
                'occasion' => 'Casual',
                'consumer_profile' => 'Young adult women interested in artisan-inspired fashion',
                'trend_notes' => 'Handcrafted embroidery and natural fibers align with slow-fashion trends.',
                'continent' => 'South America',
                'country' => 'Colombia',
                'city' => 'Bogotá',
                'captured_year' => 2026,
                'captured_month' => 6,
                'designer' => 'Gabriel',
                'raw_ai_response' => ['source' => 'seed'],
                'annotation' => [
                    'tags' => 'artisan, neckline, summer',
                    'notes' => 'This neckline could inspire a resort capsule piece.',
                    'observations' => 'Strong commercial detail with handcrafted feel.',
                ],
            ],
            [
                'image_path' => 'garments/sample-jacket.jpg',
                'original_filename' => 'sample-jacket.jpg',
                'ai_description' => 'An oversized denim jacket with utility proportions, visible stitching, and streetwear influence.',
                'garment_type' => 'Jacket',
                'style' => 'Streetwear',
                'material' => 'Denim',
                'color_palette' => 'Blue, indigo',
                'pattern' => 'Solid',
                'season' => 'Fall',
                'occasion' => 'Everyday',
                'consumer_profile' => 'Urban consumers interested in casual layering and oversized silhouettes',
                'trend_notes' => 'Oversized denim remains relevant in streetwear and casual layering.',
                'continent' => 'North America',
                'country' => 'United States',
                'city' => 'New York',
                'captured_year' => 2026,
                'captured_month' => 9,
                'designer' => 'Maria',
                'raw_ai_response' => ['source' => 'seed'],
                'annotation' => [
                    'tags' => 'oversized, denim, streetwear',
                    'notes' => 'Good reference for utility pockets and relaxed fit.',
                    'observations' => 'Could be adapted into a lighter transitional jacket.',
                ],
            ],
            [
                'image_path' => 'garments/sample-dress.jpg',
                'original_filename' => 'sample-dress.jpg',
                'ai_description' => 'A lightweight printed resort dress with tropical colors, fluid movement, and warm-weather vacation positioning.',
                'garment_type' => 'Dress',
                'style' => 'Resort',
                'material' => 'Viscose',
                'color_palette' => 'Green, coral, cream',
                'pattern' => 'Tropical print',
                'season' => 'Spring',
                'occasion' => 'Vacation',
                'consumer_profile' => 'Consumers looking for expressive warm-weather resort pieces',
                'trend_notes' => 'Tropical prints and fluid silhouettes support resort and vacation assortments.',
                'continent' => 'South America',
                'country' => 'Colombia',
                'city' => 'Cartagena',
                'captured_year' => 2026,
                'captured_month' => 4,
                'designer' => 'Gabriel',
                'raw_ai_response' => ['source' => 'seed'],
                'annotation' => [
                    'tags' => 'resort, tropical, vacation',
                    'notes' => 'Useful print direction for warm-weather capsule.',
                    'observations' => 'Color palette feels commercial for spring resort.',
                ],
            ],
        ];

        foreach ($samples as $sample) {
            $annotation = $sample['annotation'];
            unset($sample['annotation']);

            $garment = GarmentImage::create($sample);

            $garment->annotations()->create($annotation);
        }
    }
}