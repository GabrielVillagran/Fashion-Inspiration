@extends('layouts.app')

@section('title', 'Image Library - Fashion Inspiration')

@section('content')
    @php
        $sampleGarments = [
            [
                'title' => 'Embroidered Cotton Blouse',
                'description' => 'A relaxed white blouse with embroidered neckline details, natural fibers, and artisan-inspired finishing.',
                'garment_type' => 'Blouse',
                'style' => 'Bohemian',
                'material' => 'Cotton',
                'season' => 'Summer',
                'occasion' => 'Casual',
                'location' => 'Bogotá, Colombia',
            ],
            [
                'title' => 'Oversized Denim Jacket',
                'description' => 'A structured oversized denim jacket with streetwear influence, contrast stitching, and utility-inspired proportions.',
                'garment_type' => 'Jacket',
                'style' => 'Streetwear',
                'material' => 'Denim',
                'season' => 'Fall',
                'occasion' => 'Everyday',
                'location' => 'New York, USA',
            ],
            [
                'title' => 'Printed Resort Dress',
                'description' => 'A lightweight printed dress with tropical colors, fluid movement, and warm-weather vacation positioning.',
                'garment_type' => 'Dress',
                'style' => 'Resort',
                'material' => 'Viscose',
                'season' => 'Spring',
                'occasion' => 'Vacation',
                'location' => 'Cartagena, Colombia',
            ],
        ];
    @endphp

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

            <div class="filter-section">
                <h3>Garment Type</h3>
                <div class="filter-list">
                    <span class="filter-chip">Blouse</span>
                    <span class="filter-chip">Jacket</span>
                    <span class="filter-chip">Dress</span>
                </div>
            </div>

            <div class="filter-section">
                <h3>Style</h3>
                <div class="filter-list">
                    <span class="filter-chip">Bohemian</span>
                    <span class="filter-chip">Streetwear</span>
                    <span class="filter-chip">Resort</span>
                </div>
            </div>

            <div class="filter-section">
                <h3>Material</h3>
                <div class="filter-list">
                    <span class="filter-chip">Cotton</span>
                    <span class="filter-chip">Denim</span>
                    <span class="filter-chip">Viscose</span>
                </div>
            </div>

            <div class="filter-section">
                <h3>Location</h3>
                <div class="filter-list">
                    <span class="filter-chip">Colombia</span>
                    <span class="filter-chip">USA</span>
                    <span class="filter-chip">Bogotá</span>
                </div>
            </div>

            <p class="subtitle">
                These are placeholders for now. In a later phase, these filters will be generated from the database instead of being hardcoded.
            </p>
        </aside>

        <section>
            <input
                class="search-box"
                type="search"
                placeholder='Search descriptions and annotations, e.g. "embroidered neckline" or "artisan market"'
            >

            <div class="image-grid">
                @foreach ($sampleGarments as $garment)
                    <article class="card garment-card">
                        <a href="{{ route('garments.show') }}">
                            <div class="image-placeholder">
                                Image Preview
                            </div>

                            <div class="garment-content">
                                <div class="garment-title">{{ $garment['title'] }}</div>

                                <p class="garment-description">
                                    {{ $garment['description'] }}
                                </p>

                                <div class="metadata-row">
                                    <span class="tag">{{ $garment['garment_type'] }}</span>
                                    <span class="tag">{{ $garment['style'] }}</span>
                                    <span class="tag">{{ $garment['material'] }}</span>
                                    <span class="tag">{{ $garment['season'] }}</span>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </section>
    </section>
@endsection