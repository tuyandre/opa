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
        Schema::table('student_materials', function (Blueprint $table) {
            // Every existing row is in fact a certificate today (that's the only
            // thing this table has ever been used for), so default preserves data.
            $table->string('type')->default('certificate')->after('student_id')->comment('material or certificate');
            $table->unsignedBigInteger('training_session_id')->nullable()->after('type')->comment('Training Session ID');

            $table->foreign('training_session_id')->references('id')->on('training_sessions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('student_materials', function (Blueprint $table) {
            $table->dropForeign(['training_session_id']);
            $table->dropColumn(['type', 'training_session_id']);
        });
    }
};
