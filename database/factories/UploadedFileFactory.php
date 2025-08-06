<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\UploadedFile>
 */
class UploadedFileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomFilename = 'S' . fake()->date('dmY') . '.zip';

        return [
            'filename' => $randomFilename,
            'path' => fake()->filePath(),
            'mime_type' => 'application/zip',
            'size' => fake()->randomNumber(1, 5000),
            'user_id' => NULL,
            'processed' => 0,
        ];
    }
}
