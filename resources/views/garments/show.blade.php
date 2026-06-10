@extends('layouts.app')

@section('title', 'Garment Detail - Fashion Inspiration')

@section('content')
    <section class="page-header">
        <div>
            <div class="eyebrow">Garment detail</div>
            <h1>Embroidered Cotton Blouse</h1>
            <p class="subtitle">
                This page shows the difference between AI-generated classification and human designer annotations.
            </p>
        </div>

        <a href="{{ route('garments.index') }}" class="button button-secondary">Back to Library</a>
    </section>

    <section class="detail-layout">
        <div class="image-placeholder detail-image">
            Image Preview
        </div>

        <div class="form-grid">
            <div class="card">
                <h2 class="section-title">AI Description</h2>
                <p class="subtitle">
                    A relaxed white cotton blouse with embroidered neckline details, natural fibers,
                    and artisan-inspired finishing. The garment appears suitable for casual summer wear
                    and aligns with slow-fashion and handcrafted trend directions.
                </p>
            </div>

            <div class="card">
                <h2 class="section-title">AI Metadata</h2>

                <table class="metadata-table">
                    <tbody>
                        <tr>
                            <th>Garment Type</th>
                            <td>Blouse</td>
                        </tr>
                        <tr>
                            <th>Style</th>
                            <td>Bohemian</td>
                        </tr>
                        <tr>
                            <th>Material</th>
                            <td>Cotton</td>
                        </tr>
                        <tr>
                            <th>Color Palette</th>
                            <td>White, beige</td>
                        </tr>
                        <tr>
                            <th>Pattern</th>
                            <td>Embroidered</td>
                        </tr>
                        <tr>
                            <th>Season</th>
                            <td>Summer</td>
                        </tr>
                        <tr>
                            <th>Occasion</th>
                            <td>Casual</td>
                        </tr>
                        <tr>
                            <th>Consumer Profile</th>
                            <td>Young adult women interested in artisan-inspired fashion</td>
                        </tr>
                        <tr>
                            <th>Trend Notes</th>
                            <td>Handcrafted embroidery and natural fibers align with slow-fashion trends.</td>
                        </tr>
                        <tr>
                            <th>Location Context</th>
                            <td>Bogotá, Colombia</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h2 class="section-title">Designer Annotations</h2>

                <div class="form-grid">
                    <div class="form-group">
                        <label for="tags">Designer Tags</label>
                        <input id="tags" type="text" value="artisan, neckline detail, summer blouse">
                    </div>

                    <div class="form-group">
                        <label for="notes">Designer Notes</label>
                        <textarea id="notes">Interesting neckline detail. Could inspire a capsule piece with natural fabrics.</textarea>
                    </div>

                    <div class="form-group">
                        <label for="observations">Observations</label>
                        <textarea id="observations">The embroidery placement feels commercial but still handcrafted. Strong candidate for resort collection inspiration.</textarea>
                    </div>

                    <button class="button" type="button">Save Annotation</button>
                </div>
            </div>
        </div>
    </section>
@endsection