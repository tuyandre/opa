<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->string('tax_number')->nullable()->after('name');
            $table->string('contact_person')->nullable()->after('phone');
            $table->string('business_sector')->nullable()->after('address');
            $table->string('logo')->nullable()->after('business_sector');
        });
    }

    public function down(): void
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->dropColumn(['tax_number', 'contact_person', 'business_sector', 'logo']);
        });
    }
};
