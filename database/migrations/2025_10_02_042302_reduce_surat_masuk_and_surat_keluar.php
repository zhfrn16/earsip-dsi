<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ReduceSuratMasukAndSuratKeluar extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if tables exist first before dropping columns
        if (Schema::hasTable('surat_masuk')) {
            // Drop columns from surat_masuk table, keeping only pengirim
            Schema::table('surat_masuk', function (Blueprint $table) {
                if (Schema::hasColumn('surat_masuk', 'id_dokumen')) {
                    $table->dropForeign(['id_dokumen']);
                }
                if (Schema::hasColumn('surat_masuk', 'id_user')) {
                    $table->dropForeign(['id_user']);
                }

                $columnsToCheck = [
                    'id_surat_masuk',
                    'id_dokumen',
                    'id_user',
                    'file',
                    'no_surat',
                    'tanggal',
                    'sifat_surat',
                    'perihal',
                    'isi_surat'
                ];

                $columnsToDrop = [];
                foreach ($columnsToCheck as $column) {
                    if (Schema::hasColumn('surat_masuk', $column)) {
                        $columnsToDrop[] = $column;
                    }
                }

                if (!empty($columnsToDrop)) {
                    $table->dropColumn($columnsToDrop);
                }
            });
        }

        if (Schema::hasTable('surat_keluar')) {
            // Drop columns from surat_keluar table, keeping only pengirim
            Schema::table('surat_keluar', function (Blueprint $table) {
            if (Schema::hasColumn('surat_keluar', 'id_dokumen')) {
                $table->dropForeign(['id_dokumen']);
            }
            if (Schema::hasColumn('surat_keluar', 'id_user')) {
                $table->dropForeign(['id_user']);
            }

            $columnsToCheck = [
                'id_surat_keluar',
                'id_dokumen',
                'id_user',
                'file',
                'no_surat',
                'tanggal',
                'sifat_surat',
                'perihal',
                'tertuj',
                'alamat',
                'isi_surat',
                'status',
                'status_persetujuan_staff',
                'status_persetujuan_kadep'
            ];

            $columnsToDrop = [];
            foreach ($columnsToCheck as $column) {
                if (Schema::hasColumn('surat_keluar', $column)) {
                $columnsToDrop[] = $column;
                }
            }

            if (!empty($columnsToDrop)) {
                $table->dropColumn($columnsToDrop);
            }

            // Add tujuan_surat column if not exists
            if (!Schema::hasColumn('surat_keluar', 'tujuan_surat')) {
                $table->string('tujuan_surat', 255)->nullable();
            }
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Restore surat_masuk table structure
        Schema::table('surat_masuk', function (Blueprint $table) {
            $table->string('id_surat_masuk', 5)->primary();
            $table->string('id_dokumen', 5);
            $table->unsignedBigInteger('id_user');
            $table->string('file', 255)->nullable();
            $table->string('no_surat', 20);
            $table->datetime('tanggal');
            $table->string('sifat_surat', 50)->nullable();
            $table->string('perihal', 50);
            $table->text('isi_surat')->nullable();

            // Foreign key constraints
            $table->foreign('id_dokumen')->references('id_dokumen')->on('dokumen')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });

        // Restore surat_keluar table structure
        Schema::table('surat_keluar', function (Blueprint $table) {
            $table->string('id_surat_keluar', 5)->primary();
            $table->string('id_dokumen', 5);
            $table->unsignedBigInteger('id_user');
            $table->string('file', 255)->nullable();
            $table->string('no_surat', 20);
            $table->datetime('tanggal');
            $table->string('sifat_surat', 50)->nullable();
            $table->string('perihal', 50);
            $table->string('tertuj', 50);
            $table->text('alamat')->nullable();
            $table->text('isi_surat')->nullable();
            $table->integer('status')->default(0);
            $table->boolean('status_persetujuan_staff')->nullable();
            $table->boolean('status_persetujuan_kadep')->nullable();

            // Foreign key constraints
            $table->foreign('id_dokumen')->references('id_dokumen')->on('dokumen')->onDelete('cascade');
            $table->foreign('id_user')->references('id_user')->on('users')->onDelete('cascade');
        });
    }
}
