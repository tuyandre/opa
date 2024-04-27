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
        Schema::table('registration_students', function (Blueprint $table) {
            $table->string('gender')->nullable();
            $table->string('education_level')->nullable();
            $table->string('position')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registration_students', function (Blueprint $table) {
            $table->dropColumn("gender");
            $table->dropColumn("education_level");
            $table->dropColumn("position");
        });
    }
};
