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
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger('student_id')->nullable()->after('id')->comment('Student ID');
            $table->unsignedBigInteger('role_id')->nullable()->after('id')->comment('Role ID');
            $table->foreign('student_id')->references('id')->on('registration_students')->onUpdate('cascade')->onDelete('set null');
            $table->foreign('role_id')->references('id')->on('roles')->onUpdate('cascade')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropForeign(['role_id']);
            $table->dropColumn('student_id');
            $table->dropColumn('role_id');
        });
    }
};
