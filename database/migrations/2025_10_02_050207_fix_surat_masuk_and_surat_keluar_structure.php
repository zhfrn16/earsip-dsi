<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class FixSuratMasukAndSuratKeluarStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Fix surat_masuk table structure
        Schema::table('surat_masuk', function (Blueprint $table) {
            // Add id as primary key if it doesn't exist
            if (!Schema::hasColumn('surat_masuk', 'id')) {
                $table->id()->first();
            }

            // Add id_dokumen foreign key
            if (!Schema::hasColumn('surat_masuk', 'id_dokumen')) {
                $table->string('id_dokumen', 5)->after('id');
                $table->foreign('id_dokumen')->references('id_dokumen')->on('dokumen')->onDelete('cascade');
            }

            // Rename pengirim to pengirim_surat if needed
            if (Schema::hasColumn('surat_masuk', 'pengirim') && !Schema::hasColumn('surat_masuk', 'pengirim_surat')) {
                $table->renameColumn('pengirim', 'pengirim_surat');
            }
        });

        // Fix surat_keluar table structure
        Schema::table('surat_keluar', function (Blueprint $table) {
            // Add id as primary key if it doesn't exist
            if (!Schema::hasColumn('surat_keluar', 'id')) {
                $table->id()->first();
            }

            // Add id_dokumen foreign key
            if (!Schema::hasColumn('surat_keluar', 'id_dokumen')) {
                $table->string('id_dokumen', 5)->after('id');
                $table->foreign('id_dokumen')->references('id_dokumen')->on('dokumen')->onDelete('cascade');
            }

            // Remove pengirim column if it exists (not needed for surat keluar)
            if (Schema::hasColumn('surat_keluar', 'pengirim')) {
                $table->dropColumn('pengirim');
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->dropForeign(['id_dokumen']);
            $table->dropColumn(['id_dokumen']);
        });

        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->dropForeign(['id_dokumen']);
            $table->dropColumn(['id_dokumen']);
        });
    }
}
