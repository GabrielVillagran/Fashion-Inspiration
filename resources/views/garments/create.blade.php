@extends('layouts.app')

@section('title', 'Upload Image - Fashion Inspiration')

@section('content')
    <section class="page-header">
        <div>
            <div class="eyebrow">Upload inspiration</div>
            <h1>Add a Garment Image</h1>
            <p class="subtitle">
                This form will later upload the image, send it to the AI classifier, store the structured metadata,
                and redirect the designer to the image detail page.
            </p>
        </div>

        <a href="{{ route('garments.index') }}" class="button button-secondary">Back to Library</a>
    </section>

    <section class="card">
        <form class="form-grid">
            <div class="form-group">
                <label for="image">Garment Photo</label>
                <input id="image" name="image" type="file" accept="image/*">
            </div>

            <div class="form-group">
                <label for="designer">Designer</label>
                <input id="designer" name="designer" type="text" placeholder="Example: Gabriel">
            </div>

            <div class="form-group">
                <label for="continent">Continent</label>
                <input id="continent" name="continent" type="text" placeholder="Example: South America">
            </div>

            <div class="form-group">
                <label for="country">Country</label>
                <input id="country" name="country" type="text" placeholder="Example: Colombia">
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input id="city" name="city" type="text" placeholder="Example: Bogotá">
            </div>

            <div class="form-group">
                <label for="captured_year">Captured Year</label>
                <input id="captured_year" name="captured_year" type="number" placeholder="Example: 2026">
            </div>

            <div class="form-group">
                <label for="captured_month">Captured Month</label>
                <select id="captured_month" name="captured_month">
                    <option value="">Select month</option>
                    <option value="1">January</option>
                    <option value="2">February</option>
                    <option value="3">March</option>
                    <option value="4">April</option>
                    <option value="5">May</option>
                    <option value="6">June</option>
                    <option value="7">July</option>
                    <option value="8">August</option>
                    <option value="9">September</option>
                    <option value="10">October</option>
                    <option value="11">November</option>
                    <option value="12">December</option>
                </select>
            </div>

            <button class="button" type="button">
                Upload and Classify
            </button>
        </form>
    </section>
@endsection