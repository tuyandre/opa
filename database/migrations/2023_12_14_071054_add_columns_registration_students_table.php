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
        // Some environments already had these columns applied outside of Laravel's
        // migration tracking (e.g. restored from a data dump), which made this
        // migration fail with "Duplicate column" instead of being skipped. Guarding
        // each column individually lets it run safely whether none, some, or all
        // of the columns are already present.
        Schema::table('registration_students', function (Blueprint $table) {
            if (!Schema::hasColumn('registration_students', 'reply_status')) {
                $table->boolean('reply_status')->default(false)->comment('Reply Status');
            }
            if (!Schema::hasColumn('registration_students', 'reply_message')) {
                $table->text('reply_message')->comment('Reply Message')->nullable();
            }
            if (!Schema::hasColumn('registration_students', 'status')) {
                $table->string('status')->default('Pending')->comment('Status');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('registration_students', function (Blueprint $table) {
            foreach (['reply_status', 'reply_message', 'status'] as $column) {
                if (Schema::hasColumn('registration_students', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
