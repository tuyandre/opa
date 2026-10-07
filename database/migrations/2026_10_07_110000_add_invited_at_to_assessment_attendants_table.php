<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessment_attendants', function (Blueprint $table) {
            $table->timestamp('invited_at')->nullable()->after('access_code');
        });
    }

    public function down(): void
    {
        Schema::table('assessment_attendants', function (Blueprint $table) {
            $table->dropColumn('invited_at');
        });
    }
};
