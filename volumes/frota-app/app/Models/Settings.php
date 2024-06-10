<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @method static first()
 */
class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'percentageTaxIVA',
        'contabiServicelValue',
    ];

    protected $casts = [
        'percentageTaxIVA' => 'float',
        'contabiServicelValue' => 'float',
    ];
}
