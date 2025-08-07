<?php

namespace App\Http\Controllers;

use App\Models\File;
use Inertia\Inertia;

class FilesController extends Controller
{
    public function index()
    {
        return Inertia::render('files/Index', [
            'files' => File::paginate(10)
        ]);
    }
}
