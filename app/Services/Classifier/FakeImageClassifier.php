<?php

namespace App\Services\Classifier;

class FakeImageClassifier implements ImageClassifierInterface
{
    public function classify(string $imagePath, array $context = []): array
    {
        $country = $context['country'] ?? 'Unknown country';
        $city = $context['city'] ?? 'Unknown city';
        $continent = $context['continent'] ?? 'Unknown continent';

        return [
            'description' => 'A fashion inspiration image featuring a lightweight garment with casual styling, soft texture, and versatile everyday appeal.',
            'garment_type' => 'Blouse',
            'style' => 'Casual',
            'material' => 'Cotton',
            'color_palette' => 'White, beige',
            'pattern' => 'Solid',
            'season' => 'Spring',
            'occasion' => 'Everyday',
            'consumer_profile' => 'Consumers looking for comfortable, versatile, easy-to-style garments.',
            'trend_notes' => 'Soft neutrals, breathable fabrics, and simple silhouettes continue to support everyday wardrobe essentials.',
            'location_context' => [
                'continent' => $continent,
                'country' => $country,
                'city' => $city,
            ],
        ];
    }
}