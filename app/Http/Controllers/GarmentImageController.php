<?php

namespace App\Http\Controllers;

use App\Models\GarmentImage;
use Illuminate\Contracts\View\View;
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
            $search = $request->string('search')->toString();

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

        foreach ([
            'garment_type',
            'style',
            'material',
            'season',
            'occasion',
            'country',
            'city',
            'designer',
            'captured_year',
        ] as $filter) {
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

    /**
     * Show the upload page.
     */
    public function create(): View
    {
        return view('garments.create');
    }

    /**
     * Show one garment image detail page.
     */
    public function show(GarmentImage $garmentImage): View
    {
        $garmentImage->load('annotations');

        return view('garments.show', [
            'garmentImage' => $garmentImage,
        ]);
    }

    /**
     * Get unique values from a database column.
     *
     * This is how we avoid hardcoded filters.
     */
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