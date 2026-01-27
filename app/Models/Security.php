<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Security extends Model
{
    /** @use HasFactory<\Database\Factories\SecurityFactory> */
    use HasFactory;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'symbol',
        'description',
        'display_symbol',
        'security_type_id',
        'price',
        'price_refresh_time',
        'currency_id',
        'country_id',
        'exchange_id',
        'logo',
        'market_capitalization',
    ];

    /**
     * @var array<string, string>
     */
    protected $casts = [
        'price' => 'decimal:4',
        'price_refresh_time' => 'datetime',
        'market_capitalization' => 'decimal:2',
    ];

    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }

    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    public function country(): BelongsTo
    {
        return $this->belongsTo(Country::class);
    }

    public function exchange(): BelongsTo
    {
        return $this->belongsTo(Exchange::class);
    }

    public function securityType(): BelongsTo
    {
        return $this->belongsTo(SecurityType::class);
    }
}
