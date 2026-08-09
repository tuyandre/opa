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
            if (!Schema::hasColumn('registration_students', 'gender')) {
                $table->string('gender')->nullable();
            }
            if (!Schema::hasColumn('registration_students', 'education_level')) {
                $table->string('education_level')->nullable();
            }
            if (!Schema::hasColumn('registration_students', 'position')) {
                $table->string('position')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registration_students', function (Blueprint $table) {
            foreach (['gender', 'education_level', 'position'] as $column) {
                if (Schema::hasColumn('registration_students', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
