<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifySuratKeluarTableForEarsipStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Step 1: Drop existing table and recreate with new structure
        Schema::dropIfExists('surat_keluar');

        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->string('id_surat_keluar', 5)->primary();
            $table->string('id_dokumen', 5);
            $table->unsignedBigInteger('id_user');
            $table->string('file', 255)->nullable();
            $table->string('no_surat', 20);
            $table->datetime('tanggal');
            $table->string('sifat_surat', 50)->nullable();
            $table->string('pengirim', 50);
            $table->string('perihal', 50);
            $table->string('tertuj', 50);
            $table->text('alamat')->nullable();
            $table->text('isi_surat')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('status_persetujuan_staff')->nullable();
            $table->boolean('status_persetujuan_kadep')->nullable();
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
        // Drop foreign key constraints first
        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->dropForeign(['id_dokumen']);
            $table->dropForeign(['id_user']);
        });

        // Recreate original structure
        Schema::dropIfExists('surat_keluar');

        Schema::create('surat_keluar', function (Blueprint $table) {
            $table->id();
            $table->integer('id_surat');
            $table->integer('id_user');
            $table->date('tanggal_keluar');
            $table->string('sifat_surat');
            $table->string('pengirim_surat');
            $table->string('perihal');
            $table->timestamps();
        });
    }
}
