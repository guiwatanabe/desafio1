<?php

namespace Database\Factories;

use App\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublicationMetadata>
 */
class PublicationMetadataFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id' => fake()->numberBetween(0, 100000),
            'file_id' => File::factory(),
            'name' => 'Portaria ' . fake()->numberBetween(0, 100) . '-' . date('Y'),
            'id_oficio' => fake()->numberBetween(0, 100000),
            'pub_name' => 'DO2',
            'art_type' => 'Portaria',
            'pub_date' => fake()->date('Y-m-d'),
            'art_class' => '00070:00038:00001:00000:00000:00000:00000:00000:00000:00000:00017:00000',
            'art_category' => 'Poder Judiciário/Tribunal Regional Eleitoral de São Paulo/Presidência',
            'art_size' => fake()->numberBetween(5, 20),
            'art_notes' => '',
            'num_page' => fake()->numberBetween(1, 99),
            'pdf_page' => 'http://pesquisa.in.gov.br/imprensa/jsp/visualiza/index.jsp',
            'edition_number' => fake()->numberBetween(1, 99),
            'highlight_type' => NULL,
            'highlight_priority' => NULL,
            'highlight' => NULL,
            'highlight_image' => NULL,
            'highlight_image_name' => NULL,
            'id_materia' => fake()->numberBetween(0, 100000)
        ];
    }
}
