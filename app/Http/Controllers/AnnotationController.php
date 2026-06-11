<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnnotationRequest;
use App\Models\GarmentImage;
use Illuminate\Http\RedirectResponse;

class AnnotationController extends Controller
{
    public function store(
        StoreAnnotationRequest $request,
        GarmentImage $garmentImage
    ): RedirectResponse {
        $garmentImage->annotations()->create($request->validated());

        return redirect()
            ->route('garments.show', ['garmentImage' => $garmentImage->id])
            ->with('success', 'Designer annotation saved successfully.');
    }
}