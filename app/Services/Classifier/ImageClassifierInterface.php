<?php 

namespace App\Services\Classifier;

interface ImageClassifierInterface
{
    public function classify(string $imagePath, array $context = []): array;
}