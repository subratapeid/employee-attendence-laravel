<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('company_leaves', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->date('leave_date'); // Date of the leave
            $table->text('reason'); // Reason for the leave
            $table->timestamps(); // created_at and updated_at columns for tracking
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
