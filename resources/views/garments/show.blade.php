@extends('layouts.app')

@section('title', 'Garment Detail - Fashion Inspiration')

@section('content')
<section class="page-header">
    <div>
        <div class="eyebrow">Garment detail</div>
        <h1>{{ $garmentImage->garment_type ?? 'Unclassified Garment' }}</h1>
        <p class="subtitle">
            This page shows the difference between AI-generated classification and human designer annotations.
        </p>
    </div>

    <a href="{{ route('garments.index') }}" class="button button-secondary">Back to Library</a>
</section>

<section class="detail-layout">
    <div>
        @if ($garmentImage->image_path)
        <img
            class="detail-photo"
            src="{{ asset('storage/' . $garmentImage->image_path) }}"
            alt="{{ $garmentImage->garment_type ?? 'Garment image' }}"
            onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

        <div class="image-placeholder detail-image" style="display: none;">
            Image Preview
        </div>
        @else
        <div class="image-placeholder detail-image">
            Image Preview
        </div>
        @endif
    </div>

    <div class="form-grid">
        <div class="card">
            <h2 class="section-title">AI Description</h2>
            <p class="subtitle">
                {{ $garmentImage->ai_description ?? 'No AI description available yet.' }}
            </p>
        </div>

        <div class="card">
            <h2 class="section-title">AI Metadata</h2>

            <table class="metadata-table">
                <tbody>
                    <tr>
                        <th>Garment Type</th>
                        <td>{{ $garmentImage->garment_type ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Style</th>
                        <td>{{ $garmentImage->style ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Material</th>
                        <td>{{ $garmentImage->material ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Color Palette</th>
                        <td>{{ $garmentImage->color_palette ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Pattern</th>
                        <td>{{ $garmentImage->pattern ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Season</th>
                        <td>{{ $garmentImage->season ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Occasion</th>
                        <td>{{ $garmentImage->occasion ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Consumer Profile</th>
                        <td>{{ $garmentImage->consumer_profile ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Trend Notes</th>
                        <td>{{ $garmentImage->trend_notes ?? '-' }}</td>
                    </tr>
                    <tr>
                        <th>Location Context</th>
                        <td>
                            {{ collect([$garmentImage->city, $garmentImage->country, $garmentImage->continent])->filter()->join(', ') ?: '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Captured Time</th>
                        <td>
                            {{ collect([$garmentImage->captured_month, $garmentImage->captured_year])->filter()->join(' / ') ?: '-' }}
                        </td>
                    </tr>
                    <tr>
                        <th>Designer</th>
                        <td>{{ $garmentImage->designer ?? '-' }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <div class="card">
            <h2 class="section-title">Designer Annotations</h2>

            <p class="subtitle">
                These notes are human-generated and intentionally separated from the AI-generated metadata above.
            </p>

            @if ($errors->has('annotation'))
            <div class="alert alert-error">
                {{ $errors->first('annotation') }}
            </div>
            @endif

            @if ($garmentImage->annotations->isEmpty())
            <p class="subtitle">
                No designer annotations yet.
            </p>
            @else
            <div class="annotation-list">
                @foreach ($garmentImage->annotations as $annotation)
                <article class="annotation-card">
                    @if ($annotation->tags)
                    <div class="annotation-section">
                        <strong>Designer Tags</strong>
                        <p>{{ $annotation->tags }}</p>
                    </div>
                    @endif

                    @if ($annotation->notes)
                    <div class="annotation-section">
                        <strong>Designer Notes</strong>
                        <p>{{ $annotation->notes }}</p>
                    </div>
                    @endif

                    @if ($annotation->observations)
                    <div class="annotation-section">
                        <strong>Observations</strong>
                        <p>{{ $annotation->observations }}</p>
                    </div>
                    @endif

                    <p class="annotation-meta">
                        Added {{ $annotation->created_at->diffForHumans() }}
                    </p>
                </article>
                @endforeach
            </div>
            @endif

            <hr class="divider">

            <h3 class="section-title">Add Designer Annotation</h3>

            <form
                class="form-grid"
                method="POST"
                action="{{ route('garments.annotations.store', ['garmentImage' => $garmentImage->id]) }}">
                @csrf

                <div class="form-group">
                    <label for="tags">Designer Tags</label>
                    <input
                        id="tags"
                        name="tags"
                        type="text"
                        value="{{ old('tags') }}"
                        placeholder="Example: artisan, neckline detail, resort">
                    @error('tags')
                    <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="notes">Designer Notes</label>
                    <textarea
                        id="notes"
                        name="notes"
                        placeholder="Add creative notes, product ideas, or styling references...">{{ old('notes') }}</textarea>
                    @error('notes')
                    <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="observations">Observations</label>
                    <textarea
                        id="observations"
                        name="observations"
                        placeholder="Add fit, silhouette, color, material, trend, or market observations...">{{ old('observations') }}</textarea>
                    @error('observations')
                    <p class="field-error">{{ $message }}</p>
                    @enderror
                </div>

                <button class="button" type="submit">
                    Save Annotation
                </button>
            </form>
        </div>
    </div>
</section>
@endsection