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
        Schema::create('student_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id')->comment('Student ID');
            $table->string('title')->comment('Title');
            $table->text('description')->comment('Description')->nullable();
            $table->string('file')->comment('File');
            $table->string('status')->default('Active')->comment('Status');
            $table->timestamps();

            $table->foreign('student_id')->references('id')->on('registration_students')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_materials');
    }
};
