<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('training_materials', function (Blueprint $table) {
            $table->string('slug')->nullable()->after('id');
        });

        DB::table('training_materials')->orderBy('id')->select('id')->chunkById(100, function ($rows) {
            foreach ($rows as $row) {
                DB::table('training_materials')->where('id', $row->id)->update([
                    'slug' => Str::lower(Str::random(16)),
                ]);
            }
        });

        Schema::table('training_materials', function (Blueprint $table) {
            $table->unique('slug');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('training_materials', function (Blueprint $table) {
            $table->dropUnique(['slug']);
            $table->dropColumn('slug');
        });
    }
};
