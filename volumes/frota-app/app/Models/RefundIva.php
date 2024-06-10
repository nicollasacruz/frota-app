<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class RefundIva extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'description',
        'amount',
        'user_id',
        'payment_driver_id',
        'payment_date',
        'refund_date',
        'ivaPercentage',
        'ivaRefund',
    ];

    protected $casts = [
        'description' => 'string',
        'amount' => 'float',
        'user_id' => 'integer',
        'payment_driver_id' => 'integer',
        'payment_date' => 'date',
        'ivaPercentage' => 'integer',
        'ivaRefund' => 'float',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function paymentDriver(): BelongsTo
    {
        return $this->belongsTo(PaymentDriver::class, 'payment_driver_id');
    }
}
