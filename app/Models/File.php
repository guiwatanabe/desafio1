<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class File extends Model
{
    /** @use HasFactory<\Database\Factories\FileFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'uploaded_file_id',
        'filename',
        'path',
        'mime_type',
        'size',
        'processed',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [];
    }

    public function uploadedFile(): BelongsTo
    {
        return $this->belongsTo(UploadedFile::class);
    }

    public function publications(): HasMany
    {
        return $this->hasMany(PublicationMetadata::class);
    }
}
