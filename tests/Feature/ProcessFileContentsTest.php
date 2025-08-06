<?php

namespace Tests\Feature;

use App\Jobs\ProcessFileContents;
use App\Models\File;
use App\Models\PublicationMetadata;
use App\Models\UploadedFile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProcessFileContentsTest extends TestCase
{
    use RefreshDatabase;

    public function test_job_processes_xml_file_and_creates_entry()
    {
        Storage::fake('local');

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

        Storage::disk('local')->put('test.xml', $xmlContent);

        $uploadedFile = UploadedFile::factory()->create();

        $file = File::create([
            'uploaded_file_id' => $uploadedFile->id,
            'filename' => 'test.xml',
            'path' => 'test.xml',
            'mime_type' => 'application/xml',
            'size' => strlen($xmlContent),
            'processed' => 0,
        ]);

        (new ProcessFileContents($uploadedFile))->handle();

        $this->assertDatabaseCount('publication_metadata', 1);

        $metadata = PublicationMetadata::first();

        expect($metadata->id)->toBe(43283043);
        expect($metadata->file_id)->toBe($file->id);
        expect($metadata->pub_name)->toBe('DO2');
    }
}
