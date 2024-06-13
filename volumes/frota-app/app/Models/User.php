<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

/**
 * @method static create(array $data)
 * @method static where(string $string, string $string1)
 * @method static whereIn(string $string, string[] $array)
 * @method static find(mixed $user_id)
 */
class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'roles',
        'phone',
        'IBAN',
        'NIF',
        'profitPercentage',
        'hasCar',
        'rentValue',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'roles' => 'array',
    ];

    public function getIsAdminAttribute(): bool
    {
        return in_array('admin', $this->roles);
    }

    public function hasRole($role): bool
    {
        return in_array($role, $this->roles);
    }

    public function paymentsDriver(): HasMany
    {
        return $this->hasMany(PaymentDriver::class);
    }

    public function refundsIva(): HasMany
    {
        return $this->hasMany(RefundIva::class);
    }
}
