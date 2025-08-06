<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('publication_metadata', function (Blueprint $table) {
            $table->bigInteger('id', false, true)->primary();
            $table->unsignedBigInteger('file_id')->nullable();
            $table->foreign('file_id')->references('id')->on('files')->onDelete('cascade');
            $table->string('name');
            $table->bigInteger('id_oficio');
            $table->string('pub_name');
            $table->string('art_type');
            $table->date('pub_date');
            $table->string('art_class');
            $table->string('art_category');
            $table->integer('art_size', false, true)->nullable();
            $table->string('art_notes')->nullable();
            $table->integer('num_page', false, true);
            $table->string('pdf_page');
            $table->integer('edition_number', false, true);
            $table->string('highlight_type')->nullable();
            $table->string('highlight_priority')->nullable();
            $table->string('highlight')->nullable();
            $table->string('highlight_image')->nullable();
            $table->string('highlight_image_name')->nullable();
            $table->bigInteger('id_materia');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('publication_metadata');
    }
};
