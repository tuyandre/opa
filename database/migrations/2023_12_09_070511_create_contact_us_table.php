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
        Schema::create('contact_us', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->comment('Full Name')->nullable();
            $table->string('telephone')->comment('Telephone')->nullable();
            $table->string('email')->comment('Email')->nullable();
            $table->string('subject')->comment('Subject')->nullable();
            $table->text('message')->comment('Message')->nullable();
            $table->boolean('is_read')->default(false)->comment('Is Read');
            $table->boolean('is_replied')->default(false)->comment('Is Replied');
            $table->unsignedBigInteger('replied_by')->nullable()->comment('Replied By');
            $table->foreign('replied_by')->references('id')->on('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contact_us');
    }
};
