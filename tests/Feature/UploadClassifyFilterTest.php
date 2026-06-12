<?php

namespace Tests\Feature;

use App\Models\GarmentImage;
use App\Services\Classifier\FakeImageClassifier;
use App\Services\Classifier\ImageClassifierInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UploadClassifyFilterTest extends TestCase
{
    use RefreshDatabase;

    public function test_userUploadClassifyFilterImage(): void
    {
        Storage::fake('public');

        $this->app->instance(
            ImageClassifierInterface::class,
            new FakeImageClassifier()
        );

        $file = UploadedFile::fake()->createWithContent(
            'fashion-reference.png',
            base64_decode(
                'iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mP8/x8AAwMCAO+/p9sAAAAASUVORK5CYII='
            )
        );

        $uploadResponse = $this->post('/garments', [
            'image' => $file,
            'designer' => 'Gabriel',
            'continent' => 'South America',
            'country' => 'Peru',
            'city' => 'Lima',
            'captured_year' => 2026,
            'captured_month' => 7,
        ]);

        $garment = GarmentImage::query()->first();

        $this->assertNotNull($garment);

        $uploadResponse->assertRedirect(
            route('garments.show', ['garmentImage' => $garment->id])
        );

        $this->assertTrue(
            Storage::disk('public')->exists($garment->image_path),
            "The uploaded image was not found at path: {$garment->image_path}"
        );

        $this->assertSame('Blouse', $garment->garment_type);
        $this->assertSame('Casual', $garment->style);
        $this->assertSame('Cotton', $garment->material);
        $this->assertSame('Peru', $garment->country);
        $this->assertSame('Lima', $garment->city);

        $filterResponse = $this->get('/?country=Peru&captured_year=2026');

        $filterResponse->assertOk();
        $filterResponse->assertSeeText('A fashion inspiration image featuring a lightweight garment');
        $filterResponse->assertSeeText('Peru');
    }
}