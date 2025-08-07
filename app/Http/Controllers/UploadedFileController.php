<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessUploadedFiles;
use App\Models\UploadedFile;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UploadedFileController extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->all(),
            ['file' => 'required|file|mimes:zip'],
            ['file' => 'Arquivo inválido.']
        );

        if ($validator->fails()) {
            return response()->json(
                ['errors' => $validator->messages()],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $file = $request->file('file');
        $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $safeFileName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $fileName);
        $safeFileName = $safeFileName . '.zip';

        $findDuplicate = UploadedFile::firstWhere('filename', $safeFileName);
        if ($findDuplicate) {
            return response()->json(
                ['message' => 'Este arquivo já foi enviado anteriormente.'],
                Response::HTTP_OK
            );
        }

        $storeFile = $file->storeAs('uploaded_files', $safeFileName);
        if (!$storeFile) {
            return response()->json(
                ['error' => 'Falha ao salvar arquivo. Tente novamente mais tarde.'],
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $uploadedFile = UploadedFile::create([
            'filename'  => $safeFileName,
            'path'      => $storeFile,
            'mime_type' => $file->getMimeType(),
            'size'      => $file->getSize(),
            'user_id'   => $request->user()->id ?? null,
            'processed' => 0,
        ]);

        ProcessUploadedFiles::dispatch($uploadedFile);

        return response()->json(['message' => 'Arquivo criado.'], Response::HTTP_CREATED);
    }
}
