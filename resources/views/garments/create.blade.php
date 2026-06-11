@extends('layouts.app')

@section('title', 'Upload Image - Fashion Inspiration')

@section('content')
    <section class="page-header">
        <div>
            <div class="eyebrow">Upload inspiration</div>
            <h1>Add a Garment Image</h1>
            <p class="subtitle">
                Upload a garment or street-fashion photo. In this phase, the app stores the image and contextual metadata.
                In the next phase, we will classify it with AI.
            </p>
        </div>

        <a href="{{ route('garments.index') }}" class="button button-secondary">Back to Library</a>
    </section>

    <section class="card">
        @if ($errors->any())
            <div class="alert alert-error">
                <strong>Please fix the following errors:</strong>

                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form
            class="form-grid"
            method="POST"
            action="{{ route('garments.store') }}"
            enctype="multipart/form-data"
        >
            @csrf

            <div class="form-group">
                <label for="image">Garment Photo</label>
                <input id="image" name="image" type="file" accept="image/*" required>
                @error('image')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="designer">Designer</label>
                <input
                    id="designer"
                    name="designer"
                    type="text"
                    value="{{ old('designer') }}"
                    placeholder="Example: John Doe"
                >
                @error('designer')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="continent">Continent</label>
                <input
                    id="continent"
                    name="continent"
                    type="text"
                    value="{{ old('continent') }}"
                    placeholder="Example: North America"
                >
                @error('continent')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="country">Country</label>
                <input
                    id="country"
                    name="country"
                    type="text"
                    value="{{ old('country') }}"
                    placeholder="Example: United States"
                >
                @error('country')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="city">City</label>
                <input
                    id="city"
                    name="city"
                    type="text"
                    value="{{ old('city') }}"
                    placeholder="Example: Atlanta"
                >
                @error('city')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="captured_year">Captured Year</label>
                <input
                    id="captured_year"
                    name="captured_year"
                    type="number"
                    value="{{ old('captured_year') }}"
                    placeholder="Example: 2026"
                >
                @error('captured_year')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="captured_month">Captured Month</label>
                <select id="captured_month" name="captured_month">
                    <option value="">Select month</option>

                    @foreach ([
                        1 => 'January',
                        2 => 'February',
                        3 => 'March',
                        4 => 'April',
                        5 => 'May',
                        6 => 'June',
                        7 => 'July',
                        8 => 'August',
                        9 => 'September',
                        10 => 'October',
                        11 => 'November',
                        12 => 'December',
                    ] as $monthNumber => $monthName)
                        <option
                            value="{{ $monthNumber }}"
                            @selected(old('captured_month') == $monthNumber)
                        >
                            {{ $monthName }}
                        </option>
                    @endforeach
                </select>

                @error('captured_month')
                    <p class="field-error">{{ $message }}</p>
                @enderror
            </div>

            <button class="button" type="submit">
                Upload Image
            </button>
        </form>
    </section>
@endsection