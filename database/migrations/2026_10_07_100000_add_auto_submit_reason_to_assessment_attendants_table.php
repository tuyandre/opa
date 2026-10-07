<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('assessment_attendants', function (Blueprint $table) {
            // null = submitted by the attendant; 'left_page' = auto-submitted when they left the assessment page
            $table->string('auto_submit_reason', 30)->nullable()->after('submitted_at');
        });
    }

    public function down(): void
    {
        Schema::table('assessment_attendants', function (Blueprint $table) {
            $table->dropColumn('auto_submit_reason');
        });
    }
};
