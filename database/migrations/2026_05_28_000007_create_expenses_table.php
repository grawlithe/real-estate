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
        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('unit_id')->constrained()->cascadeOnDelete();
            $table->string('expense_type'); // repairs, utilities, association_dues, taxes, maintenance, other
            $table->decimal('amount', 12, 2);
            $table->date('expense_date');
            $table->text('description');
            $table->string('receipt_path')->nullable();
            $table->string('paid_by')->default('company'); // company, owner, tenant
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
