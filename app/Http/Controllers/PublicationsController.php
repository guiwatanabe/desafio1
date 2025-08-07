<?php

namespace App\Http\Controllers;

use App\Models\PublicationMetadata;
use Inertia\Inertia;

class PublicationsController extends Controller
{
    public function index()
    {
        return Inertia::render('publications/Index', [
            'publications' => PublicationMetadata::paginate(10)
        ]);
    }

    public function show(PublicationMetadata $publication)
    {
        return Inertia::render('publications/Show', [
            'publication' => $publication
        ]);
    }
}
