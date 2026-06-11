<?php

namespace App\Providers;

use App\Services\Classifier\FakeImageClassifier;
use App\Services\Classifier\ImageClassifierInterface;
use App\Services\Classifier\OpenAiImageClassifier;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ImageClassifierInterface::class, function ($app) {
            $driver = config('classifier.driver');

            if ($driver === 'openai' && config('services.openai.api_key')) {
                return $app->make(OpenAiImageClassifier::class);
            }

            return $app->make(FakeImageClassifier::class);
        });
    }

    public function boot(): void
    {
        //
    }
}
