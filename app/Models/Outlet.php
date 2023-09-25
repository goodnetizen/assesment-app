<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Outlet extends Model
{
    use HasFactory;
    use HasUuids;

    public $incrementing = false; // Indicates if the model's ID is auto-incrementing.
    protected $fillable = [
        'code',
        'name',
        'merchant_id'
    ];

    protected $casts = [
        'id' => 'string',
        'merchant_id' => 'string'
    ];

    /**
     * Get the merchant that owns the outlet.
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Get the transaction of the outlet.
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class);
    }
}
