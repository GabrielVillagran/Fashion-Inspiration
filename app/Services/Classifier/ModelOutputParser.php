<?php

namespace App\Services\Classifier;

class ModelOutputParser
{
    public function parse(array $output): array
    {
        $locationContext = $output['location_context'] ?? [];

        if (! is_array($locationContext)) {
            $locationContext = [];
        }

        return [
            'ai_description' => $this->stringOrNull($output['description'] ?? null),
            'garment_type' => $this->stringOrNull($output['garment_type'] ?? null),
            'style' => $this->stringOrNull($output['style'] ?? null),
            'material' => $this->stringOrNull($output['material'] ?? null),
            'color_palette' => $this->stringOrNull($output['color_palette'] ?? null),
            'pattern' => $this->stringOrNull($output['pattern'] ?? null),
            'season' => $this->stringOrNull($output['season'] ?? null),
            'occasion' => $this->stringOrNull($output['occasion'] ?? null),
            'consumer_profile' => $this->stringOrNull($output['consumer_profile'] ?? null),
            'trend_notes' => $this->stringOrNull($output['trend_notes'] ?? null),

            'continent' => $this->stringOrNull($locationContext['continent'] ?? null),
            'country' => $this->stringOrNull($locationContext['country'] ?? null),
            'city' => $this->stringOrNull($locationContext['city'] ?? null),

            'raw_ai_response' => $output,
        ];
    }

    private function stringOrNull(mixed $value): ?string
    {
        if ($value === null) {
            return null;
        }

        if (is_array($value)) {
            return implode(', ', array_filter($value));
        }

        $value = trim((string) $value);

        return $value !== '' ? $value : null;
    }
}