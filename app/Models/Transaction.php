<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    use HasFactory;
    use HasUuids;

    public $incrementing = false; // Indicates if the model's ID is auto-incrementing.
    protected $fillable = [
        'merchant_id',
        'outlet_id',
        'transaction_time',
        'staff',
        'pay_amount',
        'payment_type',
        'customer_name',
        'tax',
        'change_amount',
        'total_amount',
        'payment_status'
    ];

    protected $casts = [
        'id' => 'string',
        'merchant_id' => 'string',
        'outlet_id' => 'string'
    ];

    /**
     * Get the merchant that owns the transaction.
     */
    public function merchant(): BelongsTo
    {
        return $this->belongsTo(Merchant::class);
    }

    /**
     * Get the outlet that owns the transaction.
     */
    public function outlet(): BelongsTo
    {
        return $this->belongsTo(Outlet::class);
    }
}
