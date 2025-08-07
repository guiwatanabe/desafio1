<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property int $id_oficio
 * @property string $pub_name
 * @property string $art_type
 * @property string $pub_date
 * @property string $art_class
 * @property string $art_category
 * @property int $art_size
 * @property string $art_notes
 * @property int $num_page
 * @property string $pdf_page
 * @property int $edition_number
 * @property string $highlight_type
 * @property string $highlight_priority
 * @property string $highlight
 * @property string $highlight_image
 * @property string $highlight_image_name
 * @property int $id_materia
 * @property array $file
 */
class PublicationMetadataResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'idOficio' => $this->id_oficio,
            'pubName' => $this->pub_name,
            'artType' => $this->art_type,
            'pubDate' => $this->pub_date,
            'artClass' => $this->art_class,
            'artCategory' => $this->art_category,
            'artSize' => $this->art_size,
            'artNotes' => $this->art_notes,
            'numberPage' => $this->num_page,
            'pdfPage' => $this->pdf_page,
            'editionNumber' => $this->edition_number,
            'highlightType' => $this->highlight_type,
            'highlightPriority' => $this->highlight_priority,
            'highlight' => $this->highlight,
            'highlightimage' => $this->highlight_image,
            'highlightimagename' => $this->highlight_image_name,
            'idMateria' => $this->id_materia,
            'file' => new FileResource($this->file)
        ];
    }
}
