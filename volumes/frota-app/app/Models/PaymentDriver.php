<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Log;

class PaymentDriver extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'date',
        'user_id',
        'car_id',
        'valueWeekUber',
        'valueWeekBolt',
        'taxPercentage',
        'taxValue',
        'profitPercentage',
        'hasCar',
        'rentValue',
        'totalValue',
        'paymentMethod',
        'paymentStatus',
        'slotValue',
        'viaVerdeValue',
        'refund_iva_amount',
        'frotaCardValue',
        'instantPayment',
    ];

    protected $casts = [
        'date' => 'date',
        'valueWeekUber' => 'float',
        'valueWeekBolt' => 'float',
        'taxPercentage' => 'float',
        'taxValue' => 'float',
        'profitPercentage' => 'float',
        'hasCar' => 'boolean',
        'rentValue' => 'float',
        'totalValue' => 'float',
        'paymentMethod' => 'string',
        'paymentStatus' => 'string',
        'slotValue' => 'float',
        'viaVerdeValue' => 'float',
        'refunded_iva_amount' => 'float',
        'frotaCardValue' => 'float',
        'instantPayment' => 'boolean',
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
     *
     * @var RefundIva
     */
    public function closePayment(): self
    {
        Log::info('Closing payment Amount');
        Log::info('Total Value: '.$this->totalValue);
        $this->user->refundsIva()->whereNull('refund_date')->with('paymentDriver')->each(function ($refund) {
            $refund->refund_date = now();
            $refund->paymentDriver()->associate($this);
            $refund->save();
            $this->increment('refund_iva_amount', $refund->ivaRefund);
            $this->decrement('totalValue', $refund->ivaRefund);
        });
        $this->save();
        Log::info('New Total Value: '.$this->totalValue);

        return $this;
    }

    public function payDriver(): self
    {
        $this->paymentStatus = 'PAID';
        $this->save();

        return $this;
    }
}
