<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyUsersTableForEarsipStructure extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Step 1: Drop columns yang tidak diperlukan (kecuali remember_token dan email_verified_at yang diperlukan Laravel)
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['name', 'nip', 'role', 'current_team_id', 'profile_photo_path']);
        });

        // Step 2: Rename primary key
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id', 'id_user');
        });

                // Step 3: Add new columns dan modify existing ones
        Schema::table('users', function (Blueprint $table) {
            // Add new columns sesuai kebutuhan e-Arsip
            $table->string('nama_lengkap', 50)->after('id_user');
            $table->string('email', 50)->change();
            $table->string('username', 25)->change();
            $table->string('password', 255)->change();
            $table->string('foto')->nullable()->after('password');

            // Add foreign key to roles table
            $table->unsignedBigInteger('id_role')->after('foto');
            $table->foreign('id_role')->references('id_role')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Step 1: Rename back primary key
        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('id_user', 'id');
        });

        // Step 2: Drop foreign key dan columns baru
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['id_role']);
            $table->dropColumn(['nama_lengkap', 'foto', 'id_role']);
        });

        // Step 3: Restore original columns
        Schema::table('users', function (Blueprint $table) {
            $table->string('name')->after('id');
            $table->string('nip')->after('username');
            $table->smallInteger('role')->after('nip');
            $table->timestamp('email_verified_at')->nullable()->after('role');
            $table->rememberToken()->after('password');
            $table->foreignId('current_team_id')->nullable()->after('remember_token');
            $table->text('profile_photo_path')->nullable()->after('current_team_id');
            $table->text('two_factor_secret')->nullable()->after('password');
            $table->text('two_factor_recovery_codes')->nullable()->after('two_factor_secret');
        });
    }
}
