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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->foreignId('property_id')->nullable()->constrained()->nullOnDelete();
            $table->string('unit_number');
            $table->string('type'); // apartment, condo, house, commercial
            $table->string('status')->default('vacant'); // vacant, occupied, under_maintenance
            $table->string('ownership_type')->default('company_owned'); // company_owned, managed
            $table->decimal('rent_amount', 12, 2);
            $table->decimal('security_deposit', 12, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
