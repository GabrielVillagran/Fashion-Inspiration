<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreGarmentImageRequest;
use App\Models\GarmentImage;
use App\Services\Classifier\ImageClassifierInterface;
use App\Services\Classifier\ModelOutputParser;
use Illuminate\Support\Facades\Storage;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GarmentImageController extends Controller
{
    public function index(Request $request): View
    {
        $query = GarmentImage::query()
            ->with('annotations')
            ->latest();

        if ($request->filled('search')) {
            $search = $request->input('search');

            $query->where(function ($subQuery) use ($search) {
                $subQuery
                    ->where('ai_description', 'like', "%{$search}%")
                    ->orWhere('trend_notes', 'like', "%{$search}%")
                    ->orWhere('garment_type', 'like', "%{$search}%")
                    ->orWhere('style', 'like', "%{$search}%")
                    ->orWhere('material', 'like', "%{$search}%")
                    ->orWhere('pattern', 'like', "%{$search}%")
                    ->orWhere('occasion', 'like', "%{$search}%")
                    ->orWhere('consumer_profile', 'like', "%{$search}%")
                    ->orWhereHas('annotations', function ($annotationQuery) use ($search) {
                        $annotationQuery
                            ->where('tags', 'like', "%{$search}%")
                            ->orWhere('notes', 'like', "%{$search}%")
                            ->orWhere('observations', 'like', "%{$search}%");
                    });
            });
        }

        foreach (
            [
                'garment_type',
                'style',
                'material',
                'season',
                'occasion',
                'country',
                'city',
                'designer',
                'captured_year',
            ] as $filter
        ) {
            if ($request->filled($filter)) {
                $query->where($filter, $request->input($filter));
            }
        }

        $garments = $query
            ->paginate(12)
            ->withQueryString();

        $filters = [
            'garmentTypes' => $this->distinctValues('garment_type'),
            'styles' => $this->distinctValues('style'),
            'materials' => $this->distinctValues('material'),
            'seasons' => $this->distinctValues('season'),
            'occasions' => $this->distinctValues('occasion'),
            'countries' => $this->distinctValues('country'),
            'cities' => $this->distinctValues('city'),
            'designers' => $this->distinctValues('designer'),
            'years' => $this->distinctValues('captured_year'),
        ];

        return view('garments.index', [
            'garments' => $garments,
            'filters' => $filters,
        ]);
    }


    // Show the upload page.

    public function create(): View
    {
        return view('garments.create');
    }

    //Store and uploaded image
    public function store(
        StoreGarmentImageRequest $request,
        ImageClassifierInterface $classifier,
        ModelOutputParser $parser
    ): RedirectResponse {
        $validated = $request->validated();

        $uploadedFile = $request->file('image');

        $imagePath = $uploadedFile->store('garments', 'public');

        $context = [
            'designer' => $validated['designer'] ?? null,
            'continent' => $validated['continent'] ?? null,
            'country' => $validated['country'] ?? null,
            'city' => $validated['city'] ?? null,
            'captured_year' => $validated['captured_year'] ?? null,
            'captured_month' => $validated['captured_month'] ?? null,
        ];

        $absoluteImagePath = Storage::disk('public')->path($imagePath);

        $modelOutput = $classifier->classify($absoluteImagePath, $context);

        $parsedOutput = $parser->parse($modelOutput);

        $garmentImage = GarmentImage::create([
            'image_path' => $imagePath,
            'original_filename' => $uploadedFile->getClientOriginalName(),

            // User-provided context should remain the source of truth when the designer explicitly entered it.
            'designer' => $context['designer'],
            'continent' => $context['continent'] ?? $parsedOutput['continent'],
            'country' => $context['country'] ?? $parsedOutput['country'],
            'city' => $context['city'] ?? $parsedOutput['city'],
            'captured_year' => $context['captured_year'],
            'captured_month' => $context['captured_month'],

            // AI-generated metadata.
            'ai_description' => $parsedOutput['ai_description'],
            'garment_type' => $parsedOutput['garment_type'],
            'style' => $parsedOutput['style'],
            'material' => $parsedOutput['material'],
            'color_palette' => $parsedOutput['color_palette'],
            'pattern' => $parsedOutput['pattern'],
            'season' => $parsedOutput['season'],
            'occasion' => $parsedOutput['occasion'],
            'consumer_profile' => $parsedOutput['consumer_profile'],
            'trend_notes' => $parsedOutput['trend_notes'],
            'raw_ai_response' => $parsedOutput['raw_ai_response'],
        ]);

        return redirect()
            ->route('garments.show', ['garmentImage' => $garmentImage->id])
            ->with('success', 'Image uploaded and classified successfully.');
    }

    // Show garment image detail page.

    public function show(GarmentImage $garmentImage): View
    {
        $garmentImage->load('annotations');

        return view('garments.show', [
            'garmentImage' => $garmentImage,
        ]);
    }

    private function distinctValues(string $column): Collection
    {
        return GarmentImage::query()
            ->whereNotNull($column)
            ->where($column, '!=', '')
            ->distinct()
            ->orderBy($column)
            ->pluck($column);
    }
}
