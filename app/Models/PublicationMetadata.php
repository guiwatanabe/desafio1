<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PublicationMetadata extends Model
{
    /** @use HasFactory<\Database\Factories\PublicationMetadataFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'id',
        'file_id',
        'name',
        'id_oficio',
        'pub_name',
        'art_type',
        'pub_date',
        'art_class',
        'art_category',
        'art_size',
        'art_notes',
        'num_page',
        'pdf_page',
        'edition_number',
        'highlight_type',
        'highlight_priority',
        'highlight',
        'highlight_image',
        'highlight_image_name',
        'id_materia'
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [];
    }

    public function file(): BelongsTo
    {
        return $this->belongsTo(File::class);
    }
}
