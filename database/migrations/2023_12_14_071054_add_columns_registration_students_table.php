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
            $table->boolean('reply_status')->default(false)->comment('Reply Status');
            $table->text('reply_message')->comment('Reply Message')->nullable();
            $table->string('status')->default('Pending')->comment('Status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
