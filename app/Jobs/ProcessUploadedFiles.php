<?php

namespace App\Jobs;

use App\Models\File;
use App\Models\UploadedFile;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

use function Illuminate\Log\log;


/**
 * 
 * Job para processar os arquivos ZIP e extrair o
 * conteúdo para processamento posterior
 * 
 */
class ProcessUploadedFiles implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    public $uniqueFor = 300;

    public $timeout = 300;

    public function __construct(public UploadedFile $uploadedFile) {}

    public function handle(): void
    {
        $relativePath = $this->uploadedFile->path;
        $filePath = Storage::path($relativePath);

        if (!file_exists($filePath)) {
            log("[ProcessUploadedFiles::handle] Arquivo não encontrado em $filePath.");
            return;
        }

        $zip = new \ZipArchive;
        $openFile = $zip->open($filePath);

        if ($openFile !== TRUE) {
            log('[ProcessUploadedFiles::handle] Não foi possível abrir o arquivo para extração em ' . $filePath . '.');
            return;
        }

        $extractPath = 'unzipped_files/' . $this->uploadedFile->id . '/';
        $absoluteExtractPath = Storage::path($extractPath);
        if (file_exists($absoluteExtractPath)) {
            Storage::deleteDirectory($extractPath);
        }

        try {
            $zip->extractTo($absoluteExtractPath);
            $zip->close();
        } catch (\Exception $e) {
            log('[ProcessUploadedFiles::handle] Não foi possível extrair o arquivo em ' . $filePath . ' - ' . $e->getMessage() . '.');
            return;
        }

        foreach ($this->fileGenerator($absoluteExtractPath) as $file) {
            $filePath = $extractPath . $file;
            $findFile = File::firstWhere('filename', $file);
            if ($findFile) {
                if ($findFile->processed == 0) {
                    $findFile->uploaded_file_id = $this->uploadedFile->id;
                    $findFile->save();
                }
            } else {
                File::create([
                    'uploaded_file_id' => $this->uploadedFile->id,
                    'filename' => $file,
                    'path' => $filePath,
                    'mime_type' => 'application/xml',
                    'size' => Storage::fileSize($filePath),
                    'processed' => 0
                ]);
            }
        }

        $this->uploadedFile->update(['processed' => 1]);

        ProcessFileContents::dispatch($this->uploadedFile);
    }

    /**
     * Usar um generator pra iterar pelos arquivos da pasta
     *
     * @param string $directory
     * @return iterable
     */
    private function fileGenerator($directory)
    {
        foreach (scandir($directory) as $file) {
            if (!in_array($file, ['.', '..']) && is_file($directory . DIRECTORY_SEPARATOR . $file)) {
                yield $file;
            }
        }
    }

    public function uniqueId(): string
    {
        return $this->uploadedFile->filename;
    }
}
