<?php

namespace App\Observers;

use App\Models\PaymentDriver;

class PaymentDriverObserver
{
    /**
     * Handle the PaymentDriver "created" event.
     */
    public function created(PaymentDriver $paymentDriver): void
    {
        //
    }

    /**
     * Handle the PaymentDriver "creating" event.
     */
    public function creating(PaymentDriver $paymentDriver): void
    {
        $paymentDriver->taxValue = ($paymentDriver->valueWeekUber + $paymentDriver->valueWeekBolt) * ($paymentDriver->taxPercentage / 100);
        $paymentDriver->totalValue = $paymentDriver->valueWeekUber + $paymentDriver->valueWeekBolt - $paymentDriver->taxValue - $paymentDriver->rentValue - $paymentDriver->viaVerdeValue - $paymentDriver->slotValue - $paymentDriver->frotaCardValue + $paymentDriver->refund_iva_amount;
    }

    /**
     * Handle the PaymentDriver "updated" event.
     */
    public function updated(PaymentDriver $paymentDriver): void
    {
        $paymentDriver->taxValue = ($paymentDriver->valueWeekUber + $paymentDriver->valueWeekBolt) * ($paymentDriver->taxPercentage / 100);
        $paymentDriver->totalValue = $paymentDriver->valueWeekUber + $paymentDriver->valueWeekBolt - $paymentDriver->taxValue - $paymentDriver->rentValue - $paymentDriver->viaVerdeValue - $paymentDriver->slotValue - $paymentDriver->frotaCardValue + $paymentDriver->refund_iva_amount;
    }

    /**
     * Handle the PaymentDriver "deleted" event.
     */
    public function deleted(PaymentDriver $paymentDriver): void
    {
        //
    }

    /**
     * Handle the PaymentDriver "restored" event.
     */
    public function restored(PaymentDriver $paymentDriver): void
    {
        //
    }

    /**
     * Handle the PaymentDriver "force deleted" event.
     */
    public function forceDeleted(PaymentDriver $paymentDriver): void
    {
        //
    }
}
