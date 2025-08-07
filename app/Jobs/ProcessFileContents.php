<?php

namespace App\Jobs;

use App\Models\File;
use App\Models\PublicationMetadata;
use App\Models\UploadedFile;
use App\Services\AmqpPublicationPublisher;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Storage;

/**
 * 
 * Job para processar o conteúdo dos arquivos XML
 * e inserir registros no banco de dados da aplicação
 * 
 */
class ProcessFileContents implements ShouldQueue, ShouldBeUnique
{
    use Queueable;

    public $uniqueFor = 300;

    public $timeout = 300;

    protected $fileId;

    protected $amqpService;

    public function __construct(public UploadedFile $uploadedFile)
    {
        $this->fileId = $uploadedFile->id;
    }

    public function handle(): void
    {
        foreach (File::where('uploaded_file_id', $this->fileId)->where('processed', 0)->cursor() as $file) {
            // somente xml
            if (!str_contains($file->filename, '.xml')) continue;

            $this->parseFile($file);
            $file->processed = true;
            $file->save();
        }
    }

    /**
     * Interpreta o arquivo
     *
     * @param File $file
     * @return boolean
     */
    private function parseFile(File $file): bool
    {
        if (!Storage::fileExists($file->path)) return false;

        $fileContents = Storage::get($file->path);
        $xml = simplexml_load_string($fileContents);

        if ($xml === FALSE) {
            return false;
        }

        $article = $xml->article;

        $created = $this->createMetadataEntry($file->id, $article);
        if ($created) {
            $articleId = (int)$article['id'];
            $publication = PublicationMetadata::find($articleId);
            $this->publishMetadataEntry($publication);
        }

        return $created;
    }

    /**
     * Cria o registro no banco de dados
     *
     * @param integer $fileId
     * @param \SimpleXMLElement $article
     * @return bool
     */
    private function createMetadataEntry(int $fileId, \SimpleXMLElement $article): bool
    {
        $articleId = (int)$article['id'];

        if (PublicationMetadata::firstWhere('id', $articleId)) return true;

        $metadata = new PublicationMetadata([
            'id' => $articleId,
            'file_id' => $fileId,
            'name' => (string) $article['name'],
            'id_oficio' => (int)$article['idOficio'],
            'pub_name' => (string) $article['pubName'],
            'art_type' => (string) $article['artType'],
            'pub_date' => date('Y-m-d', strtotime((string) $article['pubDate'])),
            'art_class' => (string) $article['artClass'],
            'art_category' => (string) $article['artCategory'],
            'art_size' => (string) $article['artSize'],
            'art_notes' => (string) $article['artNotes'],
            'num_page' => (int)$article['numberPage'],
            'pdf_page' => (string) $article['pdfPage'],
            'edition_number' => (int)$article['editionNumber'],
            'highlight_type' => (string) $article['highlightType'],
            'highlight_priority' => (string) $article['highlightPriority'],
            'highlight' => (string) $article['highlight'],
            'highlight_image' => (string) $article['highlightimage'],
            'highlight_image_name' => (string) $article['highlightimagename'],
            'id_materia' => (int)$article['idMateria']
        ]);

        return $metadata->save();
    }

    /**
     * Publicar mensagem via AMQP
     *
     * @param PublicationMetadata $publicationMetadata
     * @return void
     */
    private function publishMetadataEntry(PublicationMetadata $publicationMetadata)
    {
        $this->amqpService = new AmqpPublicationPublisher($publicationMetadata);
        $this->amqpService->publishTopic();
    }
}
