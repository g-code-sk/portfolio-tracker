<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SecurityType extends Model
{
    /** @use HasFactory<\Database\Factories\SecurityTypeFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function securities(): HasMany
    {
        return $this->hasMany(Security::class);
    }
}
