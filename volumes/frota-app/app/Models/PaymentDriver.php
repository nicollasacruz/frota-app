<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Log;

class PaymentDriver extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'user_id',
        'car_id',
        'valueWeek',
        'taxPercentage',
        'taxValue',
        'profitPercentage',
        'hasCar',
        'rentValue',
        'totalValue',
        'paymentMethod',
        'paymentStatus',
        'platform',
        'slotValue',
        'viaVerdeValue',
        'refund_iva_amount',
        'frotaCardValue'
    ];

    protected $casts = [
        'date' => 'date',
        'valueWeek' => 'float',
        'taxPercentage' => 'float',
        'taxValue' => 'float',
        'profitPercentage' => 'float',
        'hasCar' => 'boolean',
        'rentValue' => 'float',
        'totalValue' => 'float',
        'paymentMethod' => 'string',
        'paymentStatus' => 'string',
        'platform' => 'string',
        'slotValue' => 'float',
        'viaVerdeValue' => 'float',
        'refunded_iva_amount' => 'float',
        'frotaCardValue' => 'float'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function car(): BelongsTo
    {
        return $this->belongsTo(Car::class);
    }

    public function refundsIva(): HasMany
    {
        return $this->hasMany(RefundIva::class, 'payment_driver_id');
    }

    /**
     * @return $this
     * @var RefundIva $refund
     */
    public function closePayment(): self
    {
        Log::info('Closing payment Amount');
        Log::info('Total Value: ' . $this->totalValue);
        $this->user->refundsIva()->whereNull('refund_date')->with('paymentDriver')->each(function ($refund) {
            $refund->refund_date = now();
            $refund->paymentDriver()->associate($this);
            $refund->save();
            $this->increment('refund_iva_amount', $refund->ivaRefund);
            $this->decrement('totalValue', $refund->ivaRefund);
        });
        $this->save();
        Log::info('New Total Value: ' . $this->totalValue);
        return $this;
    }

    public function payDriver(): self
    {
        $this->paymentStatus = 'PAID';
        $this->save();

        return $this;
    }

}
