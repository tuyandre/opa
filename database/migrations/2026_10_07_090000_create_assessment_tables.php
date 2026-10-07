<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('assessments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique();
            $table->string('version')->nullable();
            $table->text('description')->nullable();
            $table->foreignId('client_id')->nullable()->constrained('clients')->nullOnDelete();
            $table->foreignId('training_session_id')->nullable()->constrained('training_sessions')->nullOnDelete();
            $table->unsignedTinyInteger('pass_mark')->default(70); // percentage
            $table->decimal('marks_per_question', 6, 2)->default(2.5);
            $table->unsignedSmallInteger('suggested_minutes')->default(60);
            $table->string('status')->default('Draft'); // Draft | Active | Closed
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });

        Schema::create('assessment_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->string('title');
            $table->unsignedSmallInteger('position')->default(0);
            $table->timestamps();
        });

        Schema::create('assessment_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->foreignId('assessment_module_id')->constrained('assessment_modules')->cascadeOnDelete();
            $table->unsignedSmallInteger('position')->default(0);
            $table->string('type')->default('choice'); // choice | number
            $table->text('body');
            $table->json('options')->nullable();        // choice: {"A": "...", "B": "..."}
            $table->string('correct_answer');           // choice: option key; number: numeric value
            $table->decimal('tolerance', 14, 4)->default(0.01); // number: accepted +/- difference
            $table->string('unit')->nullable();         // number: hint shown to the attendant (RWF, %, ...)
            $table->decimal('marks', 6, 2)->nullable(); // null = assessment default
            $table->timestamps();
        });

        Schema::create('assessment_attendants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('assessment_id')->constrained('assessments')->cascadeOnDelete();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('company')->nullable();
            $table->string('access_code')->unique();
            $table->string('status')->default('Not started'); // Not started | In progress | Submitted
            $table->json('answers')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('submitted_at')->nullable();
            $table->decimal('score', 7, 2)->nullable();
            $table->decimal('total_marks', 7, 2)->nullable();
            $table->decimal('percentage', 5, 2)->nullable();
            $table->boolean('passed')->nullable();
            $table->json('module_scores')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assessment_attendants');
        Schema::dropIfExists('assessment_questions');
        Schema::dropIfExists('assessment_modules');
        Schema::dropIfExists('assessments');
    }
};
