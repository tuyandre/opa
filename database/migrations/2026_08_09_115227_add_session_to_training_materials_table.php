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
        Schema::table('training_materials', function (Blueprint $table) {
            $table->unsignedBigInteger('training_session_id')->nullable()->after('id')->comment('Training Session ID');

            $table->foreign('training_session_id')->references('id')->on('training_sessions')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_materials', function (Blueprint $table) {
            $table->dropForeign(['training_session_id']);
            $table->dropColumn('training_session_id');
        });
    }
};
