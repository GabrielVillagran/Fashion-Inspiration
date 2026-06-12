# Fashion Inspiration Library

A lightweight AI-powered web application that allows the users to upload fashion or streetwear reference images, classify them using a multimodal AI model, store structured metadata, search through the image library, apply dynamic filters, and add human designer annotations over time.

## Features

* Upload garment or street-fashion inspiration images.
* Store uploaded images using Laravel public storage.
* Classify uploaded images using a multimodal AI classifier.
* Support two classifier drivers:

  * `fake`: deterministic local classifier for development and tests.
  * `openai`: real multimodal image classification using OpenAI.
* Store AI-generated metadata:

  * Description
  * Garment type
  * Style
  * Material
  * Color palette
  * Pattern
  * Season
  * Occasion
  * Consumer profile
  * Trend notes
  * Location context
* Display uploaded images in a visual grid.
* Search across AI descriptions, trend notes, garment metadata, and designer annotations.
* Filter dynamically by:

  * Garment type
  * Style
  * Material
  * Season
  * Occasion
  * Country
  * City
  * Designer
  * Captured year
* Add designer-generated annotations:

  * Tags
  * Notes
  * Observations
* Clearly separate AI-generated metadata from human designer annotations.
* Includes unit, integration, and end-to-end style tests.

## Tech Stack

* **PHP 8.2**
* **Laravel 12**
* **Blade** for server-rendered UI
* **SQLite** for lightweight local database storage
* **Eloquent ORM** for database access
* **Laravel Storage** for uploaded images
* **Vite** for frontend asset bundling
* **OpenAI** for real multimodal image classification
* **PHPUnit / Laravel Test Suite** for automated tests

## Setup Instructions

### 1. Clone the repository

```bash
git clone <repository-url>
cd fashion-inspiration-app
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install frontend dependencies

```bash
npm install
```

### 4. Create environment file

```bash
cp .env.example .env
```

On Windows PowerShell:

```powershell
Copy-Item .env.example .env
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Configure SQLite

Create the SQLite database file:

```bash
touch database/database.sqlite
```

On Windows PowerShell:

```powershell
New-Item -ItemType File -Path database/database.sqlite -Force
```

In `.env`, set:

```env
DB_CONNECTION=sqlite
DB_DATABASE=database/database.sqlite
```

If your Laravel setup works with only `DB_CONNECTION=sqlite`, that is also acceptable.

### 7. Configure classifier driver

For local development without an API key:

```env
CLASSIFIER_DRIVER=fake
```

For real OpenAI classification:

```env
CLASSIFIER_DRIVER=openai
OPENAI_API_KEY=your_openai_api_key_here
OPENAI_MODEL=gpt-5.4-mini
```

Do not commit your `.env` file or API key to GitHub.

### 8. Run migrations and seeders

```bash
php artisan migrate --seed
```

Or reset the local database:

```bash
php artisan migrate:fresh --seed
```

### 9. Create storage symlink

```bash
php artisan storage:link
```

### 10. Run the application

Use two terminals.

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

Then open:

```text
http://127.0.0.1:8000
```

## Running Tests

Run all tests:

```bash
php artisan test
```

Run specific tests:

```bash
php artisan test --filter=ModelOutputParserTest
php artisan test --filter=GarmentFilterTest
php artisan test --filter=UploadClassifyFilterTest
```
