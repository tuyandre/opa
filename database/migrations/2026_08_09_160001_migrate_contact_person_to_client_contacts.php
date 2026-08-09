<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * clients.contact_person was a single free-text name field. Clients can have
     * more than one contact (name, phone, email, position), so it's replaced by
     * the client_contacts table — existing values are carried over as a first
     * contact row before the column is dropped.
     */
    public function up(): void
    {
        DB::table('clients')->whereNotNull('contact_person')->where('contact_person', '!=', '')->orderBy('id')
            ->select('id', 'contact_person')
            ->chunkById(100, function ($rows) {
                foreach ($rows as $row) {
                    DB::table('client_contacts')->insert([
                        'client_id' => $row->id,
                        'name' => $row->contact_person,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            });

        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn('contact_person');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('contact_person')->nullable()->after('phone');
        });
    }
};
