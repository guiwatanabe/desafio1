<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\PublicationMetadataResource;
use App\Models\PublicationMetadata;
use Illuminate\Http\Response;

class PublicationsController
{
    public function index()
    {
        return PublicationMetadata::paginate()->toResourceCollection();
    }

    public function show(string $id)
    {
        $publicationMetadata = PublicationMetadata::find($id);
        
        if (empty($publicationMetadata)) {
            return response()->json(['error' => 'Publication not found.'], Response::HTTP_NOT_FOUND);
        }

        return new PublicationMetadataResource($publicationMetadata);
    }
}
