<?php

namespace App\Providers;

use App\Services\Classifier\FakeImageClassifier;
use App\Services\Classifier\ImageClassifierInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(ImageClassifierInterface::class, FakeImageClassifier::class);
    }

    public function boot(): void
    {
        //
    }
}