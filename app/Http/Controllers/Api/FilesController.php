<?php

namespace App\Http\Controllers\Api;

use App\Models\File;

class FilesController
{
    public function index()
    {
        return File::paginate()->toResourceCollection();
    }
}
