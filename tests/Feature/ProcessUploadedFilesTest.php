<?php

namespace Tests\Feature;

use App\Jobs\ProcessUploadedFiles;
use App\Models\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;
use ZipArchive;

class ProcessUploadedFilesTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_extracts_zip_and_creates_file_records()
    {
        Storage::fake('local');

        $zipPath = Storage::disk('local')->path('uploaded_files/test.zip');

        $xmlContent = '
        <xml>
        <article id="43283043" name="trt9a74-2025-PRT COINF 86" idOficio="10954651" pubName="DO2" artType="Portaria" pubDate="05/05/2025" artClass="00070:00050:00001:00001:00017:00000:00000:00000:00000:00000:00017:00000" artCategory="Poder Judiciário/Tribunal Regional do Trabalho da 9ª Região/Tribunal Pleno/Presidência/Coordenadoria de Informações Funcionais" artSize="12" artNotes="" numberPage="117" pdfPage="http://pesquisa.in.gov.br/imprensa/jsp/visualiza/index.jsp?data=05/05/2025&amp;jornal=529&amp;pagina=117" editionNumber="82" highlightType="" highlightPriority="" highlight="" highlightimage="" highlightimagename="" idMateria="22543749">
        <body>
            <Identifica><![CDATA[ PORTARIA COINF Nº 86, DE 2 DE ABRIL DE 2025]]></Identifica>
            <Data><![CDATA[]]></Data>
            <Ementa />
            <Titulo />
            <SubTitulo />
            <Texto><![CDATA[<p class="identifica">Teste</p>]]></Texto>
        </body>
        <Midias />
        </article>
        </xml>
        ';

        if (!is_dir(dirname($zipPath))) {
            mkdir(dirname($zipPath), 0777, true);
        }

        $zip = new ZipArchive();
        $zip->open($zipPath, ZipArchive::CREATE);
        $zip->addFromString('test.xml', $xmlContent);
        $zip->close();

        $uploadedFile = UploadedFile::factory()->create([
            'filename' => 'test.zip',
            'path' => 'uploaded_files/test.zip',
        ]);

        (new ProcessUploadedFiles($uploadedFile))->handle();

        $this->assertDatabaseHas('files', [
            'uploaded_file_id' => $uploadedFile->id,
            'filename' => 'test.xml',
            'mime_type' => 'application/xml',
            'processed' => 1,
        ]);

        $this->assertFileExists(Storage::path('unzipped_files/' . $uploadedFile->id . '/test.xml'));
    }
}
