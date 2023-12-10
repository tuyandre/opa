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
        Schema::create('student_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_session_id')->comment('Session');
            $table->unsignedBigInteger('registration_student_id')->comment('Student');
            $table->unsignedBigInteger('training_service_id')->comment('Service');
            $table->timestamps();

            $table->foreign('registration_student_id')->references('id')->on('registration_students')->onDelete('cascade');
            $table->foreign('training_service_id')->references('id')->on('training_services')->onDelete('cascade');
            $table->foreign('training_session_id')->references('id')->on('training_sessions')->onDelete('cascade');

            $table->unique(['registration_student_id', 'training_session_id', 'training_service_id'], 'student_services_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_services');
    }
};
