<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyDokumenTableForEarsipStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Step 1: Drop existing table and recreate with new structure
        Schema::dropIfExists('dokumen');

        Schema::create('dokumen', function (Blueprint $table) {
            $table->string('id_dokumen', 5)->primary();
            $table->string('id_kategori', 5);
            $table->string('nama_dokumen', 100);
            $table->string('no_dokumen', 10)->nullable();
            $table->integer('tahun')->nullable();
            $table->text('deskripsi')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('id_kategori')->references('id_kategori')->on('kategori')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop foreign key constraint first
        Schema::table('dokumen', function (Blueprint $table) {
            $table->dropForeign(['id_kategori']);
        });

        // Recreate original structure
        Schema::dropIfExists('dokumen');

        Schema::create('dokumen', function (Blueprint $table) {
            $table->id();
            $table->integer('id_kategori');
            $table->string('nama_dokumen');
            $table->string('no_dokumen');
            $table->string('tahun_dokumen');
            $table->string('keterangan')->nullable();
            $table->string('file_dokumen')->nullable();
            $table->timestamps();
        });
    }
}
