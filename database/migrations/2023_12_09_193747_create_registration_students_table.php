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
        Schema::create('registration_students', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('training_session_id')->comment('Training Session');
            $table->string('full_name')->comment('Full Name');
            $table->string('email')->comment('Email');
            $table->string('telephone')->comment('Telephone');
            $table->string('company_tin')->comment('Company TIN')->nullable();
            $table->string('company_name')->comment('Company Name')->nullable();
            $table->boolean('is_paid')->default(false)->comment('Is Paid');
            $table->boolean('payment_agreement')->default(false)->comment('Payment Agreement');

            $table->text('comment')->comment('Comment')->nullable();
            $table->timestamps();


            $table->foreign('training_session_id')->references('id')->on('training_sessions')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registration_students');
    }
};
