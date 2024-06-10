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
        Schema::create('refund_ivas', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->float('amount');
            $table->foreignId('user_id')->constrained();
            $table->foreignId('payment_driver_id')->nullable()->constrained();
            $table->date('payment_date')->default(now());
            $table->date('refund_date')->nullable();
            $table->integer('ivaPercentage');
            $table->float('ivaRefund');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('refund_ivas');
    }
};
