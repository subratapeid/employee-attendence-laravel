<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('day_start_ends', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
        
            //day begin columns
            $table->string('login_status');
            $table->decimal('opening_balance', 10, 2);
            $table->json('issues_at_start')->nullable();
            $table->text('day_start_remarks')->nullable();
            // Day end columns
            $table->integer('aeps_deposit_count')->default(0);
            $table->decimal('aeps_deposit_amount', 10, 2)->default(0.00);
            $table->integer('aeps_withdrawal_count')->default(0);
            $table->decimal('aeps_withdrawal_amount', 10, 2)->default(0.00);
            $table->integer('rupay_withdrawal_count')->default(0);
            $table->decimal('rupay_withdrawal_amount', 10, 2)->default(0.00);
            $table->integer('shg_count')->default(0);
            $table->decimal('shg_amount', 10, 2)->default(0.00);
            $table->integer('fund_transfer_count')->default(0);
            $table->decimal('fund_transfer_amount', 10, 2)->default(0.00);
            $table->integer('tpd_count')->default(0);
            $table->decimal('tpd_amount', 10, 2)->default(0.00);
            $table->integer('other_count')->default(0);
            $table->decimal('other_amount', 10, 2)->default(0.00);
            $table->integer('pmjdy_count')->default(0);
            $table->integer('pmjjby_count')->default(0);
            $table->integer('pmsby_count')->default(0);
            $table->integer('rd_count')->default(0);
            $table->integer('fd_count')->default(0);
            $table->integer('apy_count')->default(0);
            $table->integer('sb_count')->default(0);
            $table->integer('zero_balance_sb_count')->default(0);
            $table->integer('pending_esign_sb_count')->default(0);
            $table->integer('pending_signature_sb_count')->default(0);
            $table->integer('ekyc_processed')->default(0);
            $table->decimal('deposited_amount_bank', 10, 2)->default(0.00);
            $table->decimal('closing_cash', 10, 2)->default(0.00);
            $table->integer('pending_transaction_count')->default(0);
            
            // Enum with default value
            $table->enum('device_issues', ['Yes', 'No'])->default('No');
            
            $table->text('issue_details')->nullable();
            $table->string('logout_status')->default('Success');
            $table->text('remarks')->nullable();
            $table->json('challenges')->nullable(); // Store challenges as JSON
            $table->text('entry_type')->default('start');
        
            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        
            $table->timestamps();
        });        
        
    }

    public function down()
    {
        Schema::dropIfExists('day_start_ends');
    }
};
