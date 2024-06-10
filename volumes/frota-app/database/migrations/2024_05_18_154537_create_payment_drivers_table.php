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
        Schema::create('payment_drivers', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('car_id')->nullable()->constrained()->nullOnDelete();
            $table->string('platform');
            $table->float('valueWeek');
            $table->float('taxPercentage');
            $table->float('taxValue');
            $table->float('slotValue');
            $table->float('viaVerdeValue')->default(0.00);
            $table->float('profitPercentage')->default(100);
            $table->boolean('hasCar');
            $table->float('rentValue');
            $table->float('refund_iva_amount')->default(0.00);
            $table->float('frotaCardValue')->default(0.00);
            $table->float('totalValue');
            $table->enum('paymentMethod', ['IBAN', 'MONEY', 'MB-WAY'])->default('IBAN');
            $table->enum('paymentStatus', ['PENDING', 'PAID'])->default('PENDING');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payment_drivers');
    }
};
