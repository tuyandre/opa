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
        Schema::create('training_sessions', function (Blueprint $table) {
            $table->id();
            $table->string('session_title')->comment('Session Title');
            $table->double('price')->comment('Session Price');
            $table->string('code')->comment('Session Code');
            $table->string('description')->comment('Session Description');
            $table->string('duration')->comment('Session Duration');
            $table->date('start_date')->comment('Session Start Date');
            $table->date('end_date')->comment('Session End Date');
            $table->string('days')->comment('Session Days');
            $table->time('start_time')->comment('Session Start Time');
            $table->time('end_time')->comment('Session End Time');
            $table->string('status')->comment('Session Status');
            $table->boolean('is_active')->default(false)->comment('Is Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('training_sessions');
    }
};
