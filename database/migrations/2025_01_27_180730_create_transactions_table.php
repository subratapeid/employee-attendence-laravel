<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->integer('deposit_count');
            $table->decimal('deposit_amount', 15, 2);
            $table->integer('withdrawal_count');
            $table->decimal('withdrawal_amount', 15, 2);
            $table->integer('transfer_count');
            $table->decimal('transfer_amount', 15, 2);
            $table->integer('other_count');
            $table->text('other_details')->nullable();
            $table->integer('enrollment_count');
            $table->integer('savings_count');
            $table->integer('deposit_accounts');
            $table->integer('aadhaar_seeding');
            $table->integer('ekyc_processed');
            $table->enum('device_issues', ['Yes', 'No']);
            $table->text('device_details')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
