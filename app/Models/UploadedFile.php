<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UploadedFile extends Model
{
    /** @use HasFactory<\Database\Factories\UploadedFileFactory> */
    use HasFactory;

    /** @var list<string> */
    protected $fillable = [
        'filename',
        'path',
        'mime_type',
        'size',
        'user_id',
        'processed',
    ];

    /** @return array<string, string> */
    protected function casts(): array
    {
        return [];
    }

    public function files(): HasMany
    {
        return $this->hasMany(File::class);
    }
}
