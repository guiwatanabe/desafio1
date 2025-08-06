<?php

namespace Database\Factories;

use App\Models\UploadedFile;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $randomFilename = fake()->numberBetween(100,999) . '_' . fake()->date('Ymd') . '_' . fake()->numberBetween(10000000, 99999999) . '.xml';

        return [
            'uploaded_file_id' => UploadedFile::factory(),
            'filename' => $randomFilename,
            'path' => fake()->filePath(),
            'mime_type' => 'application/xml',
            'size' => fake()->randomNumber(1, 5000),
            'processed' => 0,
        ];
    }
}
