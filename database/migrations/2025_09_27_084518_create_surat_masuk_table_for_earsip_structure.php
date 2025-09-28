<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuratMasukTableForEarsipStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('surat_masuk', function (Blueprint $table) {
            $table->string('id_surat_masuk', 5)->primary();
            $table->string('id_dokumen', 5);
            $table->unsignedBigInteger('id_user');
            $table->string('file', 255)->nullable();
            $table->string('no_surat', 20);
            $table->datetime('tanggal');
            $table->string('sifat_surat', 50)->nullable();
            $table->string('pengirim', 50);
            $table->string('perihal', 50);
            $table->text('isi_surat')->nullable();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('id_dokumen')->references('id_dokumen')->on('dokumen')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('surat_masuk');
    }
}
