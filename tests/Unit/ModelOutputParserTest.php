<?php

namespace Tests\Unit;

use App\Services\Classifier\ModelOutputParser;
use PHPUnit\Framework\TestCase;

class ModelOutputParserTest extends TestCase
{
    public function test_parsesModelIntoDatabaseFields(): void
    {
        $parser = new ModelOutputParser();

        $result = $parser->parse([
            'description' => 'A relaxed embroidered cotton blouse.',
            'garment_type' => 'Blouse',
            'style' => 'Bohemian',
            'material' => 'Cotton',
            'color_palette' => ['White', 'Beige'],
            'pattern' => 'Embroidered',
            'season' => 'Summer',
            'occasion' => 'Casual',
            'consumer_profile' => 'Young adult consumer interested in artisan fashion.',
            'trend_notes' => 'Embroidery and natural fibers support slow-fashion direction.',
            'location_context' => [
                'continent' => 'North America',
                'country' => 'Canada',
                'city' => 'Toronto',
            ],
        ]);

        $this->assertSame('A relaxed embroidered cotton blouse.', $result['ai_description']);
        $this->assertSame('Blouse', $result['garment_type']);
        $this->assertSame('Bohemian', $result['style']);
        $this->assertSame('Cotton', $result['material']);
        $this->assertSame('White, Beige', $result['color_palette']);
        $this->assertSame('North America', $result['continent']);
        $this->assertSame('Canada', $result['country']);
        $this->assertSame('Toronto', $result['city']);
        $this->assertIsArray($result['raw_ai_response']);
    }

    public function test_handlesMissingOrEmptyValuesSafely(): void
    {
        $parser = new ModelOutputParser();

        $result = $parser->parse([
            'description' => '',
            'garment_type' => null,
            'location_context' => 'not-an-array',
        ]);

        $this->assertNull($result['ai_description']);
        $this->assertNull($result['garment_type']);
        $this->assertNull($result['country']);
        $this->assertIsArray($result['raw_ai_response']);
    }
}