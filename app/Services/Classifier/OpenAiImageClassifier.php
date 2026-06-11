<?php

namespace App\Services\Classifier;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use RuntimeException;

class OpenAiImageClassifier implements ImageClassifierInterface
{

    public function classify(string $imagePath, array $context = []): array
    {
        $apiKey = config('services.openai.api_key');
        $model = config('services.openai.model');

        if (! $apiKey) {
            throw new RuntimeException('OPENAI_API_KEY is not configured.');
        }

        if (! file_exists($imagePath)) {
            throw new RuntimeException("Image file not found: {$imagePath}");
        }

        $imageDataUrl = $this->toDataUrl($imagePath);

        $prompt = $this->buildPrompt($context);

        $response = Http::withToken($apiKey)
            ->timeout(90)
            ->acceptJson()
            ->asJson()
            ->post('https://api.openai.com/v1/responses', [
                'model' => $model,
                'input' => [
                    [
                        'role' => 'user',
                        'content' => [
                            [
                                'type' => 'input_text',
                                'text' => $prompt,
                            ],
                            [
                                'type' => 'input_image',
                                'image_url' => $imageDataUrl,
                            ],
                        ],
                    ],
                ],
            ]);

        if ($response->failed()) {
            Log::error('OpenAI image classification failed.', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            throw new RuntimeException('OpenAI image classification request failed.');
        }

        $payload = $response->json();

        $text = $this->extractTextFromResponse($payload);

        if (! $text) {
            Log::error('OpenAI response did not contain extractable text.', [
                'payload' => $payload,
            ]);

            throw new RuntimeException('OpenAI response did not contain text.');
        }

        $decoded = $this->decodeJsonOutput($text);

        if (! is_array($decoded)) {
            Log::error('OpenAI response was not valid JSON.', [
                'text' => $text,
            ]);

            throw new RuntimeException('OpenAI response was not valid JSON.');
        }

        return $decoded;
    }

    private function buildPrompt(array $context): string
    {
        $contextText = json_encode($context, JSON_PRETTY_PRINT);

        return <<<PROMPT
You are a fashion garment classification assistant.

Analyze the uploaded garment or street-fashion image and return ONLY valid JSON.
Do not include markdown.
Do not include explanations outside the JSON.

Use this exact JSON structure:

{
  "description": "Rich natural-language description of the garment and visual context.",
  "garment_type": "Example: blouse, jacket, dress, pants, skirt, sweater, shirt, coat, footwear, accessory, unknown",
  "style": "Example: streetwear, casual, bohemian, formal, resort, minimalist, vintage, athletic, unknown",
  "material": "Best visual estimate. Example: cotton, denim, leather, wool, silk, polyester, linen, unknown",
  "color_palette": "Main visible colors, comma separated.",
  "pattern": "Example: solid, striped, floral, embroidered, plaid, graphic, animal print, unknown",
  "season": "Example: spring, summer, fall, winter, trans-seasonal, unknown",
  "occasion": "Example: casual, workwear, evening, vacation, athletic, formal, everyday, unknown",
  "consumer_profile": "Likely target consumer profile.",
  "trend_notes": "Brief notes about trend relevance, inspiration value, or design opportunity.",
  "location_context": {
    "continent": "Use provided context if available, otherwise infer only if visually obvious, otherwise unknown.",
    "country": "Use provided context if available, otherwise infer only if visually obvious, otherwise unknown.",
    "city": "Use provided context if available, otherwise infer only if visually obvious, otherwise unknown."
  }
}

User-provided context:
{$contextText}

Important:
- If the image does not clearly show a garment, set uncertain fields to "unknown".
- Do not invent precise material or location if not visually clear.
- Prefer useful fashion-design language.
PROMPT;
    }

    private function toDataUrl(string $imagePath): string
    {
        $mimeType = mime_content_type($imagePath) ?: 'image/jpeg';

        $base64 = base64_encode(file_get_contents($imagePath));

        return "data:{$mimeType};base64,{$base64}";
    }

    /**
     * Extract text from different possible response shapes.
     *
     * @param array<string, mixed> $payload
     */
    private function extractTextFromResponse(array $payload): ?string
    {
        if (isset($payload['output_text']) && is_string($payload['output_text'])) {
            return $payload['output_text'];
        }

        $chunks = [];

        foreach ($payload['output'] ?? [] as $outputItem) {
            foreach ($outputItem['content'] ?? [] as $contentItem) {
                if (isset($contentItem['text']) && is_string($contentItem['text'])) {
                    $chunks[] = $contentItem['text'];
                }
            }
        }

        $text = trim(implode("\n", $chunks));

        return $text !== '' ? $text : null;
    }

    /**
     * Decode JSON even if the model accidentally wraps it in markdown fences.
     *
     * @return array<string, mixed>|null
     */
    private function decodeJsonOutput(string $text): ?array
    {
        $cleanText = trim($text);

        $cleanText = preg_replace('/^```json\s*/', '', $cleanText);
        $cleanText = preg_replace('/^```\s*/', '', $cleanText);
        $cleanText = preg_replace('/\s*```$/', '', $cleanText);

        $decoded = json_decode($cleanText, true);

        return is_array($decoded) ? $decoded : null;
    }
}