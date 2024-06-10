<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Car extends Model
{
    use HasFactory;

    protected $fillable = [
        'brand',
        'model',
        'year',
        'color',
        'license_plate',
    ];

    protected $casts = [
        'brand' => 'string',
        'model' => 'string',
        'year' => 'integer',
        'color' => 'string',
        'license_plate' => 'string',
    ];

    public function paymentDrivers(): HasMany
    {
        return $this->hasMany(PaymentDriver::class);
    }
}
