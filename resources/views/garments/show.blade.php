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

            @if ($garmentImage->annotations->isEmpty())
            <p class="subtitle">
                No designer annotations yet.
            </p>
            @else
            @foreach ($garmentImage->annotations as $annotation)
            <div class="form-grid">
                <div class="form-group">
                    <label>Designer Tags</label>
                    <input type="text" value="{{ $annotation->tags }}" disabled>
                </div>

                <div class="form-group">
                    <label>Designer Notes</label>
                    <textarea disabled>{{ $annotation->notes }}</textarea>
                </div>

                <div class="form-group">
                    <label>Observations</label>
                    <textarea disabled>{{ $annotation->observations }}</textarea>
                </div>
            </div>
            @endforeach
            @endif
        </div>
    </div>
</section>
@endsection