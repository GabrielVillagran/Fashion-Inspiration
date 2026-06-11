@extends('layouts.app')

@section('title', 'Image Library - Fashion Inspiration')

@section('content')
<section class="page-header">
    <div>
        <div class="eyebrow">AI-powered fashion archive</div>
        <h1>Inspiration Image Library</h1>
        <p class="subtitle">
            Upload garment and street-fashion images, classify them with AI, search by natural language,
            filter by metadata, and add human designer observations over time.
        </p>
    </div>

    <a href="{{ route('garments.create') }}" class="button">Upload New Image</a>
</section>

<section class="library-layout">
    <aside class="card">
        <h2 class="section-title">Dynamic Filters</h2>

        @php
        $filterGroups = [
        'garment_type' => ['label' => 'Garment Type', 'values' => $filters['garmentTypes']],
        'style' => ['label' => 'Style', 'values' => $filters['styles']],
        'material' => ['label' => 'Material', 'values' => $filters['materials']],
        'season' => ['label' => 'Season', 'values' => $filters['seasons']],
        'occasion' => ['label' => 'Occasion', 'values' => $filters['occasions']],
        'country' => ['label' => 'Country', 'values' => $filters['countries']],
        'city' => ['label' => 'City', 'values' => $filters['cities']],
        'designer' => ['label' => 'Designer', 'values' => $filters['designers']],
        'captured_year' => ['label' => 'Year', 'values' => $filters['years']],
        ];
        @endphp

        @foreach ($filterGroups as $filterName => $group)
        @if ($group['values']->isNotEmpty())
        <div class="filter-section">
            <h3>{{ $group['label'] }}</h3>

            <div class="filter-list">
                @foreach ($group['values'] as $value)
                <a
                    class="filter-link {{ request($filterName) == $value ? 'active' : '' }}"
                    href="{{ route('garments.index', array_merge(request()->except('page'), [$filterName => $value])) }}">
                    {{ $value }}
                </a>
                @endforeach
            </div>
        </div>
        @endif
        @endforeach

        @if (request()->query())
        <a href="{{ route('garments.index') }}" class="button button-secondary">
            Clear Filters
        </a>
        @endif

        <p class="subtitle">
            These filter values are now generated from the database instead of being hardcoded.
        </p>
    </aside>

    <section>
        <form method="GET" action="{{ route('garments.index') }}">
            <input
                class="search-box"
                name="search"
                type="search"
                value="{{ request('search') }}"
                placeholder='Search descriptions and annotations, e.g. "embroidered neckline" or "artisan market"'>
        </form>

        @if ($garments->isEmpty())
        <div class="card empty-state">
            <h2>No garment images found</h2>
            <p>
                Upload your first inspiration image or seed the database with sample data.
            </p>
            <a href="{{ route('garments.create') }}" class="button">Upload Image</a>
        </div>
        @else
        <div class="image-grid">
            @foreach ($garments as $garment)
            <article class="card garment-card">
                <a href="{{ route('garments.show', ['garmentImage' => $garment->id]) }}"> @if ($garment->image_path)
                    <img
                        class="garment-image"
                        src="{{ asset('storage/' . $garment->image_path) }}"
                        alt="{{ $garment->garment_type ?? 'Garment image' }}"
                        onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">

                    <div class="image-placeholder" style="display: none;">
                        Image Preview
                    </div>
                    @else
                    <div class="image-placeholder">
                        Image Preview
                    </div>
                    @endif

                    <div class="garment-content">
                        <div class="garment-title">
                            {{ $garment->garment_type ?? 'Unclassified Garment' }}
                        </div>

                        <p class="garment-description">
                            {{ $garment->ai_description ?? 'No AI description yet.' }}
                        </p>

                        <div class="metadata-row">
                            @if ($garment->style)
                            <span class="tag">{{ $garment->style }}</span>
                            @endif

                            @if ($garment->material)
                            <span class="tag">{{ $garment->material }}</span>
                            @endif

                            @if ($garment->season)
                            <span class="tag">{{ $garment->season }}</span>
                            @endif

                            @if ($garment->country)
                            <span class="tag">{{ $garment->country }}</span>
                            @endif
                        </div>
                    </div>
                </a>
            </article>
            @endforeach
        </div>

        <div class="pagination-wrapper">
            {{ $garments->links() }}
        </div>
        @endif
    </section>
</section>
@endsection